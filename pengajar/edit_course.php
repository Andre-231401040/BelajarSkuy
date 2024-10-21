<?php 
require "../function.php";
session_start();

$id_pengajar = $_SESSION["id"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama = $data_pengajar["nama"];
$gambar = $data_pengajar["foto_profil"];

$id_kursus = $_GET['id'];

$kursus = pg_fetch_assoc(pg_query($con, "SELECT * FROM kursus WHERE id = $id_kursus"));

pg_close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edit Course </title>
    <!-- Quicksand Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <!--Style-->
    <link rel="stylesheet" href="styles/edit_course.css" />
</head>
<body>
    <header>
    <nav>
            <a href="./edit_profil.php" class="profil">
                <?php if($gambar != null){ ?>
                    <img src="../images/pengajar/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
                <?php }else{ ?>
                    <img src="../images/pengajar/foto_profil/foto-1.jpg" alt="foto profil default">
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

    <div class="container">
        <div class="left-content">
            <h2>Judul</h2>
            <h2>Deskripsi</h2>
            <h2>Kategori</h2>
            <h2>Harga</h2>
            <h2>Materi (PDF)</h2>
            <h2>Materi (Video)</h2>
            <h2>Tugas</h2>
            <h2>Kuis</h2>
        </div>

        <div class="right-content">
            <div class="course-card"></div>
            <div class="course-card"></div>
            <div class="course-card"></div>
            <div class="course-card"></div>
            <div class="course-card"></div>
            <div class="course-card"></div>
            <div class="course-card"></div>
            <div class="course-card"></div>
        </div>
    </div>


    <a href="#" class="finish-course"> selesai </a>

</body>
</html>
