<?php
require "../function.php";
session_start();

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$profil = $data_siswa["foto_profil"];

$data_course = pg_query($con, "SELECT * FROM kursus");

$data_success = pg_fetch_assoc(pg_query($con, "SELECT * FROM success_payment WHERE id_siswa = $id_siswa"));
if($data_success != null){
  $id_course_success = $data_success["id"];
} else{
  $id_course_success = null;
}
pg_close();
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course</title>
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles/coursestyle.css">
  </head>
  <body>
    <header>
    <nav>
            <a href="./profil_siswa.php" class="profil">
                <?php if($profil != null){ ?>
                    <img src="../images/foto_profil/<?= $profil; ?>" alt="foto profil <?= $nama; ?>">
                <?php }else{ ?>
                    <img src="../images/foto_profil/foto-1.jpg" alt="foto profil default">
                <?php } ?>
                <div class="nama">
                    <h2><?= $nama; ?></h2>
                    <div class="underline"></div>
                </div>
            </a>
            <ul>
                <li>
                    <a href="./home.php">Home</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="./course.php">Course</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="">Forum</a>
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
      <div class="container-sebelummain">
        <h2>Most Popular Course</h2>
      </div>
      <div class="container-main">
        <?php while($row = pg_fetch_assoc($data_course)) { ?>
        <div class="container-course">
          <div class="container-circle">
          <div class="circle-2"></div>
          <div class="circle-2"></div>
          <div class="circle-2"></div>
          </div>
          <img src="../thumbnail/<?= $row["thumbnail"]?>" class="gambarKurs" alt="<?= $row["judul"]?>"/>
          <h1 class="judul"><?= $row["judul"] ?></h1>
          <div class="container-circle2">
            <div class="circle-3"></div>
            <p><?= $row["jumlah_siswa"]; ?></p>
          </div>
          <div class="container-circle2">
          <div class="circle-3"></div>
            <p><?= $row["kategori"]; ?></p>
          </div>
          <div class="container-circle2">
            <div class="circle-3"></div>
            <p><?= $row["harga"]; ?></p>
          </div>
          <div class="container-linktabel">
            <?php if (($row["id"] == $id_course_success)) { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $row['id']?>" class="rectangle-3" id="Enroll-free">Start</a>
            <?php } else if ($row["harga"] != 0) { ?>
              <a href="pay.php?id=<?= $row['id']?>" class="rectangle-3" id="Enroll">Enroll Me</a>
            <?php } else { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $row['id']?>" class="rectangle-3" id="Enroll-free">Enroll Me</a>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
      </div>
    </main>
  </body>
</html>
