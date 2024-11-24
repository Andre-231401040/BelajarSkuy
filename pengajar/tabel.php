<?php 
require "../function.php";
session_start();

if (!isset($_SESSION["id_pengajar"])) {
    header("Location: ../home/login.php");
    exit;
}

$id_pengajar = $_SESSION["id_pengajar"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$gambar = $data_pengajar["foto_profil"];
$nama = $data_pengajar["nama"];

// Mendapatkan ID kursus dari URL atau sesi
if (!isset($_GET["id_kursus"])) {
    header("Location: ../home.php"); // Redirect jika ID kursus tidak ditemukan
    exit;
}

$id_kursus = (int) $_GET["id_kursus"]; // Validasi ID kursus sebagai integer

// Query data tabel siswa
$data_tabel = pg_query($con, "SELECT * 
                              FROM siswa 
                              JOIN enroll ON siswa.id = enroll.id_siswa 
                              JOIN kursus ON enroll.id_kursus = kursus.id 
                              WHERE kursus.id = $id_kursus");

$tabel = pg_fetch_all($data_tabel); // Mendapatkan semua data siswa dalam array
pg_close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Siswa</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <link rel="stylesheet" href="./styles/tabelstyle.css">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
</head>
<body>

    <header>
        <nav>
            <a href="./edit_profil.php" class="profil">
                <?php if ($gambar != null) { ?>
                    <img src="../images/foto_profil/<?= $gambar; ?>" alt="foto profil pengajar">
                <?php } else { ?>
                    <img src="../images/foto_profil/foto-1.jpg" alt="foto profil default">
                <?php } ?>
                <div class="nama">
                    <h2><?= htmlspecialchars($data_pengajar['nama']); ?></h2>
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

    <div class="container-tabel">
        <h1>Daftar Siswa</h1>
        <div class="tabel-siswa">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Jenjang Sekolah</th>
                        <th>Asal Sekolah</th>
                        <th>Email</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($tabel) { // Hanya tampilkan baris jika ada data siswa ?>
                        <?php foreach ($tabel as $row) { ?>
                            <tr>
                                <td class="profile">
                                    <?php if ($row["foto_profil"] != null) { ?>
                                        <img src="../images/foto_profil/<?= htmlspecialchars($row["foto_profil"]); ?>" alt="foto profil <?= htmlspecialchars($row['nama']); ?>" class="profile-pic">
                                    <?php } else { ?>
                                        <img src="../images/foto_profil/foto-1.jpg" alt="foto profil default" class="profile-pic">
                                    <?php } ?>
                                    <span><?= htmlspecialchars($row['nama']); ?></span>
                                </td>
                                <td><?= htmlspecialchars($row['jenjang'] ?? '-'); ?></td>
                                <td><?= htmlspecialchars($row['asal_sekolah'] ?? '-'); ?></td>
                                <td>
                                    <a href="mailto:<?= htmlspecialchars($row['email']); ?>">
                                        <?= htmlspecialchars($row['email']); ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

</body>

<script> 
    const hamburgerBtn = document.querySelector(".hamburger");
    const navList = document.querySelector(".container");
    hamburgerBtn.addEventListener("click", () => {
        navList.classList.toggle("display");
    });
</script>
</html>
