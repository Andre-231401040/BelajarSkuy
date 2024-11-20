<?php 
require "../function.php";
session_start();

if(!isset($_SESSION["id_pengajar"])){
    header("Location: ../home/login.php");
}

$id_pengajar = $_SESSION["id_pengajar"];
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
                    move_uploaded_file($tmp_name, "../images/foto_profil/" . $foto_profil);
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
        <div class="atas">
            <?php if($foto_profil != null){ ?>
                <img src="../images/foto_profil/<?= $foto_profil; ?>" alt="foto profil <?= $nama; ?>">
            <?php }else{ ?>
                <img src="../images/foto_profil/foto-1.jpg" alt="foto profil default">
            <?php } ?>
            <div class="nama">
                    <h2><?= $nama; ?></h2>
                    <h3>pengajar</h3>
            </div>
        </div>


        <div class="bawah">
            <form action="./edit_profil.php" method="post" enctype="multipart/form-data">
                <div class = "button-profile">
                    <label for="foto-profil" class= "custom-profile">
                        ubah foto
                        <input type="file" id="foto-profil" name="foto-profil" style="display : none">
                    </labe>
                </div>
            
                <div class="data">
                    <div class= form-section>
                        <div class= input-data>
                            <label for="nama">Nama</label>
                            <input type="text" id="nama" name="nama" value="<?= $nama; ?>" required>
                        </div>
                        <div class= input-data>
                            <label for="tanggal_lahir">Tanggal Lahir</label>
                            <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="<?= $tanggal_lahir; ?>" required>
                        </div>
                    </div>
                    <div class= form-section>
                        <div class= input-data>
                            <label for="pekerjaan">Pekerjaan</label>
                            <input type="text" id="pekerjaan" name="pekerjaan" value="<?= $pekerjaan; ?>">
                        </div>
                        <div class= input-data>
                            <label for="jenjang">Jenjang</label>
                            <input type="text" id="jenjang" name="jenjang" required value="<?= $email; ?>">
                        </div>
                    </div>
                    <div class= form-section>
                        <div class= input-data>
                            <label for="email">Email</label>
                            <input type="text" id="email" name="email" value="<?= $email; ?>">
                        </div>
                        <div class= input-data>
                            <label for="nomor_handphone">Nomor Handphone</label>
                            <input type="text" id="nomor_handphone" name="nomor_handphone" value="<?= $nomor_handphone; ?>">
                        </div>
                    </div>
                    <div class= form-section>
                        <div class= input-data>
                            <label for="password">Kata Sandi</label>
                            <input type="password" id="password" name="password" value="<?= $password; ?>" required>
                        </div>
                        <div class= input-data>
                            <label for="confirmation_password">Konfirmasi Kata Sandi</label>
                            <input type="password" id="confirmation_password" name="confirmation_password" value="<?= $confirmation_password; ?>" required>
                        </div>
                    </div>
                    <div class= form-section>
                        <div class= input-data>
                            <label for="bidang_keahlian">Bidang Keahlian</label>
                            <input type="bidang_keahlian" id="bidang_keahlian" name="bidang_keahlian" value="<?= $bidang_keahlian; ?>" required>
                        </div>
                    </div>

                    <div class= form-section>
                        <div class= deskripsi>
                            <label for="deskripsi_diri">Deskripsi Diri</label>
                            <textarea id="deskripsi_diri" name="deskripsi_diri"><?= $deskripsi_diri; ?></textarea>
                        </div>
                    </div>
                </div>
                <button type="submit" name="submit">Simpan</button>
            </form>
        </div>   
    </main>
</body>
</html>