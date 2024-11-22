<?php
require "../function.php";
session_start();

if(!isset($_SESSION["id_siswa"])){
  header("Location: ../home/login.php");
}

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$profil = $data_siswa["foto_profil"];

$data_course = pg_query($con, "SELECT kursus.id, judul, nama, pendidikan_terakhir, jenjang, jumlah_siswa, harga, thumbnail FROM kursus INNER JOIN pengajar ON kursus.id_pengajar = pengajar.id;");

pg_close();
?>




<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
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
          </div>
        </a>
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="container">
          <div class="navigation">
            <a href="home.php">Beranda</a>
            <a href="course.php">Kursus</a>
            <a href="../forum_siswa.php">Forum</a>
          </div>
        </nav>
    </header>
    <main>
        <label class="jenjang" for="jenjang">
          <select id="jenjang">
            <option value="" disabled selected hidden>Jenjang</option>
            <option value="SD">SD</option>
            <option value="SMP">SMP</option>
            <option value="SMA">SMA</option>
            <option value="Lainnya">Lainnya</option>
          </select>
          <svg>
            <use xlink:href="#select-arrow-down"></use>
          </svg>
      </label>
      <svg class="sprites">
        <symbol id="select-arrow-down" viewbox="0 0 10 6">
          <polyline points="1 1 5 5 9 1"></polyline>
        </symbol>
      </svg>
      <div class="container-main">
        <?php while($row = pg_fetch_assoc($data_course)) { 
          $id_kursus = $row["id"];  
        ?>
        <div class="container-course">
          <img src="../thumbnail/<?= $row["thumbnail"]?>" class="gambarKurs" alt="<?= $row["judul"]?>"/>
          <h1 class="judul"><?= $row["judul"]?></h1>
          <div class="container-circle2">
            <div class="bold">Nama Pengajar</div>: <?= $row["nama"]; ?>
          </div>
          <div class="container-circle2">
            <div class="bold">Pendidikan Terakhir</div>: <?= $row['pendidikan_terakhir']; ?>
          </div>
          <div class="container-circle2">
           <div class="bold">Jenjang</div>: <span class="jenjang-card"><?= $row["jenjang"]; ?></span>
          </div>
          <div class="container-circle2">
            <div class="bold">Jumlah Murid</div>: <?= $row["jumlah_siswa"]; ?>
          </div>
          <div class="container-circle2">
            <div class="bold">Harga</div>: Rp<?= $row["harga"]; ?>
          </div>
          <div class="container-linktabel">
            <?php if (pg_affected_rows(pg_query($con, "SELECT * FROM success_payment WHERE id = $id_kursus AND id_siswa = $id_siswa")) != 0) { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $id_kursus; ?>" class="rectangle-3" id="Enroll-free">Bergabung</a>
            <?php } else if ($row["harga"] != 0) { ?>
              <a href="pay.php?id=<?= $id_kursus; ?>" class="rectangle-3" id="Enroll">Enroll Saya</a>
            <?php } else { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $id_kursus; ?>" class="rectangle-3" id="Enroll-free">Bergabung</a>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
      </div>
    </main>
  </body>
  <script> 
    const hamburgerBtn = document.querySelector(".hamburger");
      const navList = document.querySelector(".container");
      hamburgerBtn.addEventListener("click", () => {
        if(navList.classList.contains("display")){
          navList.classList.remove("display");
        }else{
          navList.classList.add("display");
        }
      });

      const inputJenjang = document.getElementById("jenjang");
      const jenjangKeseluruhan = document.querySelectorAll(".jenjang-card");
      inputJenjang.addEventListener("change", function(){
        Array.from(jenjangKeseluruhan).forEach(jenjang => {
          if(jenjang.innerHTML !== inputJenjang.value){
            jenjang.parentElement.parentElement.style.display = "none";
          }else{
            jenjang.parentElement.parentElement.style.display = "grid";
          }
        });
      })
  </script>
</html>
