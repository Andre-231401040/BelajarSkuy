<?php 
require "../function.php";
session_start();

$id_pengajar = $_SESSION["id"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));

$nama = $data_pengajar["nama"];
$tanggal_lahir = $data_pengajar["tanggal_lahir"];
$email = $data_pengajar["email"];
$password = $data_pengajar["password"];
$confirmation_password = $data_pengajar["password"];
$pendidikan_terakhir = $data_pengajar["pendidikan_terakhir"];
$pekerjaan = $data_pengajar["pekerjaan"];
$nomor_handphone = $data_pengajar["nomor_handphone"];
$bidang_keahlian = $data_pengajar["bidang_keahlian"];
$deskripsi_diri = $data_pengajar["deskripsi_diri"];
$foto_profil = $data_pengajar["foto_profil"];

if(isset($_POST["submit"])){
    $nama = $_POST["nama"];
    $tanggal_lahir = $_POST["tanggal_lahir"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirmation_password = $_POST["confirmation_password"];
    $pendidikan_terakhir = $_POST["pendidikan_terakhir"];
    $pekerjaan = $_POST["pekerjaan"];
    $nomor_handphone = $_POST["nomor_handphone"];
    $bidang_keahlian = $_POST["bidang_keahlian"];
    $deskripsi_diri = $_POST["deskripsi_diri"];

    if($password !== $confirmation_password){
        echo "<script>alert('Password dan Confirmation Password Harus Sama')</script>";
    }else{
        // upload gambar
        if($_FILES["foto-profil"]["size"] !== 0){
            $nama_file = $_FILES["foto-profil"]["name"];
            $ukuran_file = $_FILES["foto-profil"]["size"];
            $error = $_FILES["foto-profil"]["error"];
            $tmp_name = $_FILES["foto-profil"]["tmp_name"];
    
            // cek apakah gambar valid atau tidak
            $ekstensi_valid = ["jpg", "png", "jpeg"];
            $ekstensi_gambar = explode(".", $nama_file);
            $ekstensi_gambar = strtolower(end($ekstensi_gambar));
            if(!in_array($ekstensi_gambar, $ekstensi_valid)){
                echo "<script>alert('Silahkan masukkan gambar dengan ekstensi jpg, jpeg, atau png')</script>";
            }else{
                // cek ukuran gambar
                if($ukuran_file > 2000000){
                    echo "<script>alert('Ukuran gambar terlalu besar')</script>";
                }else{
                    // generate nama file baru
                    $foto_profil = uniqid();
                    $foto_profil .= "." . $ekstensi_gambar;
                    move_uploaded_file($tmp_name, "../images/pengajar/foto_profil/" . $foto_profil);
                    $query = "UPDATE pengajar 
                    SET nama = '$nama', tanggal_lahir = '$tanggal_lahir', email = '$email', password = '$password', pendidikan_terakhir = '$pendidikan_terakhir', pekerjaan = '$pekerjaan', nomor_handphone = '$nomor_handphone', bidang_keahlian = '$bidang_keahlian', deskripsi_diri = '$deskripsi_diri', foto_profil = '$foto_profil'
                    WHERE id = $id_pengajar";
                    $result = pg_query($con, $query);
                
                    if(!$result){
                        echo "<script>Data Gagal Diubah</script>";
                    }else{
                        echo "<script>Data Berhasil Diubah</script>";
                    }     
                }
            }
        }else{
            $query = "UPDATE pengajar 
            SET nama = '$nama', tanggal_lahir = '$tanggal_lahir', email = '$email', password = '$password', pendidikan_terakhir = '$pendidikan_terakhir', pekerjaan = '$pekerjaan', nomor_handphone = '$nomor_handphone', bidang_keahlian = '$bidang_keahlian', deskripsi_diri = '$deskripsi_diri', foto_profil = '$foto_profil'
            WHERE id = $id_pengajar";
            $result = pg_query($con, $query);
        
            if(!$result){
                echo "<script>Data Gagal Diubah</script>";
            }else{
                echo "<script>Data Berhasil Diubah</script>";
            }
        }
    }
}

pg_close($con);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?> | Profil</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Fonts -->
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Style -->
     <link rel="stylesheet" href="./styles/edit_profil.css">
    
</head>
<body>
    <main>
        <form action="./edit_profil.php" method="post" enctype="multipart/form-data">
            <?php if($foto_profil != null){ ?>
                <img src="../images/pengajar/foto_profil/<?= $foto_profil; ?>" alt="foto profil <?= $nama; ?>">
            <?php }else{ ?>
                <img src="../images/pengajar/foto_profil/foto-1.jpg" alt="foto profil default">
            <?php } ?>
            <label for="nama">Nama
                <input type="text" id="nama" name="nama" value="<?= $nama; ?>" required>
            </label>
            <label for="tanggal_lahir">Tanggal Lahir
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= $tanggal_lahir; ?>" required>
            </label>
            <label for="pendidikan_terakhir">Pendidikan Terakhir
                <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" value="<?= $pendidikan_terakhir; ?>">
            </label>
            <label for="pekerjaan">Pekerjaan
                <input type="text" id="pekerjaan" name="pekerjaan" value="<?= $pekerjaan; ?>">
            </label>
            <label for="email">Email
                <input type="text" id="email" name="email" required value="<?= $email; ?>">
            </label>
            <label for="nomor_handphone">No Handphone
                <input type="text" id="nomor_handphone" name="nomor_handphone" value="<?= $nomor_handphone; ?>">
            </label>
            <label for="bidang_keahlian">Bidang Keahlian
                <input type="text" id="bidang_keahlian" name="bidang_keahlian" value="<?= $bidang_keahlian; ?>">
            </label>
            <label for="password">Password
                <input type="password" id="password" name="password" value="<?= $password; ?>" required>
            </label>
            <label for="confirmation_password">Confirmation Password
                <input type="password" id="confirmation_password" name="confirmation_password" value="<?= $confirmation_password; ?>" required>
            </label>
            <label for="deskripsi_diri">Deskripsi Diri
                <textarea id="deskripsi_diri" name="deskripsi_diri"><?= $deskripsi_diri; ?></textarea>
            </label>
            <label for="foto-profil">
                Foto Profil
                <input type="file" id="foto-profil" name="foto-profil">
            </label>
            <button type="submit" name="submit">Simpan</button>
        </form>
    </main>
</body>
</html>