<?php 
require "../function.php";

if(isset($_POST["submit"])){
    $nama = $_POST["first-name"] . ' ' . $_POST["last-name"];
    $tanggal_lahir = $_POST["birth-date"];
    $asal_sekolah = $_POST["school"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirmation-password"];

    if($password !== $confirm_password){
        echo "<p class='failed'>Registrasi Gagal</p>";
    }else{
        $query = "INSERT INTO siswa (nama, tanggal_lahir, asal_sekolah, email, password) VALUES ('$nama', '$tanggal_lahir', '$asal_sekolah', '$email', '$password')";
        $result = pg_query($con, $query);
    
        if(!$result){
            echo "<p class='failed'>Registrasi Gagal</p>";
        }else{
            echo "<p class='success'>Registrasi Berhasil</p>";
        }
    }
    
    pg_close($con);
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BelajarSkuy</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Fonts -->
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="styles/register.css" />
  </head>
  <body>
    <main>
        <div class="image">
            <h2>Perjalanan Belajar Anda Dimulai di Sini!</h2>
            <img src="../images/logo.png" alt="logo belajarskuy">
        </div>
        <form method="post" action="register_student.php" autocomplete="off">
            <h1>Buat Akun Murid</h1>
            <div class="form-row">
                <div class="input-data">
                    <label for="first-name">Nama Depan</label>
                    <input type="text" id="first-name" name="first-name" required>
                </div>
                <div class="input-data">
                    <label for="last-name">Nama Belakang</label>
                    <input type="text" id="last-name" name="last-name">
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <label for="birth-date">Tanggal Lahir</label>
                    <input type="date" id="birth-date" name="birth-date" required>
                </div>
                <div class="input-data">
                    <label for="school">Sekolah / Instansi</label>
                    <input type="text" id="school" name="school" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data email">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required>
                </div>
            </div>
            <div class="form-row">
                <div class="input-data">
                    <label for="password">Kata Sandi</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" required>
                </div>
                <div class="input-data">
                    <label for="confirmation-password">Konfirmasi Kata Sandi</label>
                    <input type="password" id="confirmation-password" name="confirmation-password" autocomplete="new-password" required>
                </div>
            </div>
            <div class="form-row">
                <div class="create-btn">
                    <button type="submit" name="submit">Daftar</button>
                </div>
            </div>
            <div class="links">Sudah memiliki akun? <a href="login.php">Masuk</a></div>
        </form>
    </main>
  </body>
</html>
