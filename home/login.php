<?php 
require "function.php";

if(isset($_POST["login"])){
  $email = $_POST["email"];
  $isFoundStudent = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE email = '$email'"));
  $isFoundTeacher = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE email = '$email'"));

  if($isFoundStudent){
    $password = $_POST["password"];
    if($password === $isFoundStudent['password']){
      header("Location: ../siswa/coba.html");
    }else{
      echo "<p class='failed'>Password Salah</p>";
    }
  }else if($isFoundTeacher){
    $password = $_POST["password"];
    if($password === $isFoundTeacher["password"]){
      header("Location: ../pengajar/coba.html");
    }else{
      echo "<p class='failed'>Password Salah</p>";
    }
  }else{
      echo "<p class='failed'>Email tidak ditemukan</p>";
  }
}

pg_close($con);

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BelajarSkuy</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Fonts -->
    <!-- Racing Sans One -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet" />
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="styles/login.css" />

    <style>
        .failed{
            width: 180px;
            padding: 8px;
            position: absolute;
            text-align: center;
            left: 50%;
            margin: 12px 0 0 -160px;  
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
      <article class="login-form">
        <img src="../images/Belajar skuy (2).png" alt="logo belajarskuy" />
        <form method="post" action="login.php">
          <h1>Login</h1>
          <div class="input-data">
            <input type="text" name="email" id="email" required />
            <div class="underline"></div>
            <label for="email">Email</label>
          </div>
          <div class="input-data">
            <input type="password" name="password" id="password" autocomplete="new-password" required />
            <div class="underline"></div>
            <label for="password">Password</label>
          </div>
          <button type="submit" name="login">Login</button>
          <div class="links">    
            <a href="register_student.php">Create an account</a>  
            <a href="">Forget Password?</a>
          </div>
        </form>
      </article>
    </main>
    <script>
      const registerButton = document.querySelector(".register-button");
      const registerOption = document.querySelector(".register-option");
      registerButton.addEventListener("click", () => {
        if (registerOption.style.opacity == 0) {
          registerOption.style.opacity = 1;
        } else {
          registerOption.style.opacity = 0;
        }
      });
    </script>
  </body>
</html>
