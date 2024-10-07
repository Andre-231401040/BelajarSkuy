<?php 
require "function.php";

if(isset($_POST["submit"])){
    $nama = $_POST["first-name"] . ' ' . $_POST["last-name"];
    $tanggal_lahir = $_POST["birth-date"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $confirm_password = $_POST["confirmation-password"];

    if($password !== $confirm_password){
        echo "<p class='failed'>Registrasi Gagal</p>";
    }else{
        $query = "INSERT INTO pengajar (nama, tanggal_lahir, email, password) VALUES ('$nama', '$tanggal_lahir', '$email', '$password')";
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

    <style>
        .input-data.birth-date{
            width: 100%;
        }
        .success, .failed{
            width: 160px;
            padding: 8px;
            position: absolute;
            left: 50%;
            margin: 12px 0 0 -160px;  
            border: 1px solid green;
            background-color: rgba(153, 255, 51, 0.5);
        }

        .failed{
            border: 1px solid red;
            background-color: rgba(255, 153, 153, 0.5);
        }
    </style>
  </head>
  <body>
    <header>
      <a href="index.html"><img src="../images/home (1).png" alt="logo menu home" /></a>
    </header>
    <main>
        <div class="image">
            <h2>Your Teaching Journey Starts Here!</h2>
            <img src="../images/logo.png" alt="logo belajarskuy">
        </div>
        <form method="post" action="register_teacher.php">
            <h1>Create Teacher Account</h1>
            <div class="form-row">
                <div class="input-data">
                    <label for="first-name">First Name</label>
                    <input type="text" id="first-name" name="first-name" required>
                </div>
                <div class="input-data">
                    <label for="last-name">Last Name</label>
                    <input type="text" id="last-name" name="last-name">
                </div>
            </div>
            <div class="form-row">
                <div class="input-data birth-date">
                    <label for="birth-date">Birth</label>
                    <input type="date" id="birth-date" name="birth-date" required>
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
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="new-password" required>
                </div>
                <div class="input-data">
                    <label for="confirmation-password">Confirmation Password</label>
                    <input type="password" id="confirmation-password" name="confirmation-password" autocomplete="new-password" required>
                </div>
            </div>
            <div class="form-row">
                <div class="create-btn">
                    <button type="submit" name="submit">Create Account</button>
                </div>
            </div>
            <div class="links">Already have an account? <a href="login.php">Login</a></div>
        </form>
    </main>
  </body>
</html>
