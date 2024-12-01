<?php 
require "../function.php";
session_start();

if(!isset($_SESSION["id_siswa"])){
    header("Location: ../home/login.php");
}

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));

$nama = $data_siswa["nama"];
$tanggal_lahir = $data_siswa["tanggal_lahir"];
$email = $data_siswa["email"];
$password = $data_siswa["password"];
$confirmation_password = $data_siswa["password"];
$asal_sekolah = $data_siswa["asal_sekolah"];
$nomor_handphone = $data_siswa["nomor_handphone"];
$minat = $data_siswa["minat"];
$deskripsi_diri = $data_siswa["deskripsi_diri"];
$foto_profil = $data_siswa["foto_profil"];
$jenjang = $data_siswa["jenjang"];

if(isset($_POST["submit"])){
    $nama = htmlspecialchars($_POST["nama"]);
    $tanggal_lahir = htmlspecialchars($_POST["tanggal_lahir"]);
    $email = htmlspecialchars($_POST["email"]);
    $jenjang = htmlspecialchars($_POST["jenjang"]);
    $password = htmlspecialchars($_POST["password"]);
    $confirmation_password = htmlspecialchars($_POST["confirmation_password"]);
    $asal_sekolah = htmlspecialchars($_POST["asal_sekolah"]);
    $nomor_handphone = htmlspecialchars($_POST["nomor_handphone"]);
    $minat = htmlspecialchars($_POST["minat"]);
    $deskripsi_diri = htmlspecialchars($_POST["deskripsi_diri"]);

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
                    $query = "UPDATE siswa 
                    SET nama = '$nama', tanggal_lahir = '$tanggal_lahir', email = '$email', password = '$password', asal_sekolah = '$asal_sekolah', nomor_handphone = '$nomor_handphone',minat = '$minat', deskripsi_diri = '$deskripsi_diri', foto_profil = '$foto_profil'
                    WHERE id = $id_siswa";
                    $result = pg_query($con, $query);
                
                    if(!$result){
                        echo "<script>Data Gagal Diubah</script>";
                    }else{
                        echo "<script>Data Berhasil Diubah</script>";
                    }     
                }
            }
        }else{
            $query = "UPDATE siswa 
            SET nama = '$nama', tanggal_lahir = '$tanggal_lahir', email = '$email', password = '$password',asal_sekolah = '$asal_sekolah', nomor_handphone = '$nomor_handphone', minat = '$minat', deskripsi_diri = '$deskripsi_diri', foto_profil = '$foto_profil'
            WHERE id = $id_siswa";
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
     <link rel="stylesheet" href="./styles/profil_siswa.css">
    
</head>
<body>
    <main>
        <div class="profil-atas">
            <?php if($foto_profil != null){ ?>
                <img src="../images/foto_profil/<?= $foto_profil; ?>" alt="foto profil <?= $nama; ?>">
            <?php }else{ ?>
                <img src="../images/foto_profil/foto-1.jpg" alt="foto profil default">
            <?php } ?>
            <div class="nama">
                    <h2><?= $nama; ?></h2>
                    <h3>siswa</h3>
            </div>
        </div>


        <div class="profil-bawah">
            <form action="./profil_siswa.php" method="post" enctype="multipart/form-data">
                <div class = "button-profile">
                    <label for="foto-profil" class= "custom-profile">
                        ubah foto
                        <input type="file" id="foto-profil" name="foto-profil" style="display : none">
                    </labe>
                </div>
            
                <div class="profil-data">
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
                            <label for="asal_sekolah">Asal Sekolah</label>
                            <input type="text" id="asal_sekolah" name="asal_sekolah" value="<?= $asal_sekolah; ?>">
                        </div>
                        <div class= input-data>
                            <label for="jenjang">Jenjang</label>
                            <input type="text" id="jenjang" name="jenjang" required value="<?= $jenjang; ?>">
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
                            <label for="minat">Bidang Diminati</label>
                            <input type="minat" id="minat" name="minat" value="<?= $minat; ?>" required>
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