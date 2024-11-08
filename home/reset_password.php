<?php 
require "../function.php";

if(isset($_POST["reset"])){
    $email = $_POST["email"];
    $isFoundStudent = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE email = '$email'"));
    $isFoundTeacher = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE email = '$email'"));
  
    if($isFoundStudent){
        $newPassword = uniqid();
        $res = pg_query($con, "UPDATE siswa SET password = '$newPassword' WHERE email = '$email'");
        if(!$res){
            echo "<p class='failed'>Password gagal direset</p>";
        }
    }else if($isFoundTeacher){
        $newPassword = uniqid();
        $res = pg_query($con, "UPDATE pengajar SET password = '$newPassword' WHERE email = '$email'");
        if(!$res){
            echo "<p class='failed'>Password gagal direset</p>";
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
    <link rel="stylesheet" href="styles/reset.css" />
  </head>
  <body>
    <main>
      <article class="reset-form">
        <img src="../images/logo.png" alt="logo belajarskuy" />
        <form method="post" action="reset_password.php">
          <h1>Reset Password</h1>
          <div class="input-data">
            <input type="text" name="email" id="email" required />
            <div class="underline"></div>
            <label for="email">Email</label>
          </div>
          <?php if(isset($newPassword)) : ?>
            <p>Password baru anda : <?= $newPassword; ?></p>
            <a href="login.php">Login</a>
          <?php endif; ?>
          <button type="submit" name="reset">Reset</button>
        </form>
      </article>
    </main>
  </body>
</html>
