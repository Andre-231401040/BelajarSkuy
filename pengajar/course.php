<?php 
require "../function.php";
session_start();

if(!isset($_SESSION["id_pengajar"])){
  header("Location: ../home/login.php");
}

$id_pengajar = $_SESSION["id_pengajar"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama = $data_pengajar["nama"];
$gambar = $data_pengajar["foto_profil"];

$data = pg_query($con, "SELECT * FROM kursus WHERE id_pengajar = $id_pengajar");

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $nama; ?> | Course</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Quicksand Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!--Style-->
    <link rel="stylesheet" href="styles/course.css" />
  </head>
  <body>
    <header>
      <nav>
          <a href="./edit_profil.php" class="profil">
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
                  <a href="../forum_pengajar.php">Forum</a>
              </div>
          </div>
      </nav>
    </header> 

    <a href="./edit_course.php" class="add-course"> + </a>

    <div class="course-container">
      <?php while($row = pg_fetch_assoc($data)){ ?>
        <div class="course-card">
          <img src="../thumbnail/<?= $row["thumbnail"]; ?>" alt="thumbnail kursus <?= $row["judul"]; ?>">
          <h2><?= $row["judul"]; ?></h2>
          <?php if(is_null($row["jumlah_siswa"])){ ?>
            <p>0 siswa terdaftar <a href="./tabel.php?id_kursus=<?= $row["id"]; ?>">Lihat</a></p>
          <?php }else{ ?>
            <p><?= $row["jumlah_siswa"]; ?> murid terdaftar <a href="./tabel.php?id_kursus=<?= $row["id"]; ?>">Lihat</a></p>
          <?php } ?>
          <p>Jenjang: <?= $row["kategori"]; ?></p>
          <p>Harga: Rp<?= $row["harga"]; ?></p>
          <div class="button-container">
            <a href="edit_course.php?id_kursus=<?= $row["id"]; ?>">Edit</a>
            <a href="hapus_course.php?id_kursus=<?= $row["id"]; ?>">Hapus</a>
          </div>
        </div>
      <?php } ?>
    </div>


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
  </body>
</html>
