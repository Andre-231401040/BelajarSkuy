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

$data_enrolled_courses = pg_query($con, "SELECT DISTINCT ON (enroll.id_kursus) * FROM kursus INNER JOIN enroll ON kursus.id = enroll.id_kursus WHERE enroll.id_siswa = $id_siswa");
$courses = pg_fetch_all($data_enrolled_courses);

$data_latest_courses = pg_query($con, "SELECT judul, harga FROM kursus ORDER BY id DESC LIMIT 6");
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
            <ul>
                <li>
                    <a href="./home.php">Beranda</a>
                </li>
                <li>
                    <a href="./course.php">Kursus</a>
                </li>
                <li>
                    <a href="../forum_siswa.php">Forum</a>
                </li>
            </ul>
        </nav>
    </header>

    <h1 style="margin-left: 55px;margin-top:45px; color: white">Hi, <?= $nama; ?> </h1>

    <div class="container">
        <div class="rectangle">
            <p class="title">Kursus Anda</p>
        </div>

        <div class="course">
            <div class="courserectangle">

            </div>
            <div class="courserectangle">

            </div>
            <div class="courserectangle">

            </div>
        </div>
    </div>

    <div class="container">
        <div class="rectangle">
            <p class="title">Kursus Terbaru </p>
        </div>

        <div class="course">
            <div class="courserectangle">

            </div>
            <div class="courserectangle">

            </div>
            <div class="courserectangle">

            </div>
        </div>
    </div>
    
    
   
</body>
</html>