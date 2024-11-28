<?php 
require "../function.php";
session_start();

if(!isset($_SESSION["id_siswa"])){
    header("Location: ../home/login.php");
}

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$gambar = $data_siswa["foto_profil"];

$data_course = pg_query($con, "SELECT * FROM kursus");

// $data_enrolled_courses = pg_query($con, "SELECT judul, DISTINCT ON (enroll.id_kursus) * FROM kursus INNER JOIN enroll ON kursus.id = enroll.id_kursus WHERE enroll.id_siswa = $id_siswa");
$data_enrolled_courses = pg_query($con, "SELECT kursus.id, judul, nama, pendidikan_terakhir, jenjang, jumlah_siswa, harga, thumbnail FROM kursus INNER JOIN pengajar ON kursus.id_pengajar = pengajar.id INNER JOIN enroll ON kursus.id = enroll.id_kursus WHERE enroll.id_siswa = $id_siswa");
$courses = pg_fetch_all($data_enrolled_courses);

$data_latest_courses = pg_query($con, "SELECT kursus.id, judul, nama, pendidikan_terakhir, jenjang, jumlah_siswa, harga, thumbnail FROM kursus INNER JOIN pengajar ON kursus.id_pengajar = pengajar.id ORDER BY kursus.id DESC LIMIT 3");
$latest_courses = pg_fetch_all($data_latest_courses);

pg_close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?> | Home</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <link rel="stylesheet" href="styles/homeStyle.css">

    <!-- Fonts -->
    <!-- Racing Sans One -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet" />
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />

</head>
<body>
    
    <header>
      <nav>
          <a href="./profil_siswa.php" class="profil">
              <?php if($gambar != null){ ?>
                  <img src="../images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
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
                  <a href="./home.php">Beranda</a>
                  <a href="./course.php">Kursus</a>
                  <a href="../forum_siswa.php">Forum</a>
              </div>
          </div>
      </nav>
    </header>
    
    <main>
    <h1 style="color: #2E7DBF;">Selamat Datang, <?= $nama; ?></h1>

    <div class="main-section">
        <div class="title-rectangle">
            <p class="title">Kursus yang Anda Beli</p>
        </div>

        <div class="container-main">
        <?php 
            while($row = pg_fetch_assoc($data_enrolled_courses)) { 
            $id_kursus = $row["id"];  
        ?>
        <div class="container-course">
          <img src="../thumbnail/<?= $row["thumbnail"]?>" class="gambarKurs" alt="<?= $row["judul"]?>"/>
          <h2 class="judul"><?= $row["judul"]?></h2>
          <div class="course-attribute">
            <div class="bold">Nama Pengajar</div>: <?= $row["nama"]; ?>
          </div>
          <div class="course-attribute">
            <div class="bold">Pendidikan Terakhir</div>: <?= $row["pendidikan_terakhir"]; ?>
          </div>
          <div class="course-attribute">
           <div class="bold">Jenjang</div>: <?= $row["jenjang"]; ?>
          </div>
          <div class="course-attribute">
            <div class="bold">Jumlah Siswa</div>: <?= $row["jumlah_siswa"]; ?> &nbsp; <a href="./tabel_siswa.php?id_kursus=<?= $row["id"]; ?>">Lihat</a>
          </div>
          <div class="course-attribute">
            <div class="bold">Harga</div>: <?= $row["harga"]; ?>
          </div>
          <div class="container-linktabel">
            <?php if (pg_affected_rows(pg_query($con, "SELECT * FROM success_payment WHERE id = $id_kursus AND id_siswa = $id_siswa")) !== 0) { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $row['id']?>" class="enroll-rectangle" id="Enroll-free">Bergabung</a>
            <?php } else if ($row["harga"] != 0) { ?>
              <a href="pay.php?id=<?= $row['id']?>" class="enroll-rectangle" id="Enroll">Enroll Saya</a>
            <?php } else { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $row['id']?>" class="enroll-rectangle" id="Enroll-free">Bergabung</a>
            <?php } ?>
          </div>
        </div>
        <?php } ?>
      </div>
    </div>

    <div class="main-section">
        <div class="title-rectangle">
            <p class="title">Kursus Terbaru </p>
        </div>


        <div class="container-main">
        <?php foreach ($latest_courses as $row): 
          $id_kursus = $row["id"];    
        ?>
        <div class="container-course">
          <img src="../thumbnail/<?= $row["thumbnail"]?>" class="gambarKurs" alt="<?= $row["judul"]?>"/>
          <h2 class="judul"><?= $row["judul"]?></h2>
          <div class="course-attribute">
            <div class="bold">Nama Pengajar</div>: <?= $row["nama"]; ?>
          </div>
          <div class="course-attribute">
            <div class="bold">Pendidikan Terakhir</div>: <?= $row["pendidikan_terakhir"]; ?>
          </div>
          <div class="course-attribute">
           <div class="bold">Jenjang</div>: <?= $row["jenjang"]; ?>
          </div>
          <div class="course-attribute">
            <div class="bold">Jumlah Siswa</div>: <?= $row["jumlah_siswa"]; ?> &nbsp; <a href="./tabel_siswa.php?id_kursus=<?= $row["id"]; ?>">Lihat</a>
          </div>
          <div class="course-attribute">
            <div class="bold">Harga</div>: <?= $row["harga"]; ?>
          </div>
          <div class="container-linktabel">
            <?php if (pg_affected_rows(pg_query($con, "SELECT * FROM success_payment WHERE id = $id_kursus AND id_siswa = $id_siswa")) !== 0) { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $row['id']?>" class="enroll-rectangle" id="Enroll-free">Bergabung</a>
            <?php } else if ($row["harga"] != 0) { ?>
              <a href="pay.php?id=<?= $row['id']?>" class="enroll-rectangle" id="Enroll">Enroll Saya</a>
            <?php } else { ?>
              <a href="tambahJumlahSiswa.php?id=<?= $row['id']?>" class="enroll-rectangle" id="Enroll-free">Bergabung</a>
            <?php } ?>
          </div>
        </div>
        <?php  endforeach;  ?>
      </div>
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
  </script>

</html>