<?php 
require "function.php";
session_start();

if(!isset($_SESSION["isFound"])){
    header("Location: home/login.php");
}

if($_SESSION["isFound"] === "student"){
    $id_siswa = $_SESSION["id_siswa"];
    $data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
    $nama = $data_siswa["nama"];
    $gambar = $data_siswa["foto_profil"];
    $status = "siswa";
}else if($_SESSION["isFound"] === "teacher"){
    $id_pengajar = $_SESSION["id_pengajar"];
    $data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
    $nama = $data_pengajar["nama"];
    $gambar = $data_pengajar["foto_profil"];
    $status = "pengajar";
}

// Memastikan ada ID postingan dalam URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Invalid Post ID.");
}

$id_postingan = (int)$_GET['id']; // Mengambil ID postingan dari URL

// Mengambil komentar untuk ID postingan tersebut
$data_komentar = pg_query($con, "SELECT * FROM komentar WHERE id_postingan = $id_postingan ORDER BY waktu_dibuat DESC");
if (!$data_komentar) {
    die("Error fetching comments: " . pg_last_error($con));
}


// Menutup koneksi database
pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comments</title>
    <link rel="icon" href="./images/logo.png" sizes="32x32" type="image/png" />
    <link rel="stylesheet" href="stylesQuestions.css">
</head>
<body>
    <header>
        <div class="container-header">
            <div class="rectangle">
                <?php if($gambar != null){ ?>
                    <img src="images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>" class="profile-pic">
                <?php }else{ ?>
                    <img src="images/foto_profil/foto-1.jpg" alt="foto profil default" class="profile-pic">
                <?php } ?>
                <p class="nama"><?= $nama; ?></p>
            </div>
            <nav class="navigation">
                <?php if($status === "pengajar"){ ?>
                    <a href="./pengajar/home.php">home</a>
                    <a href="./pengajar/course.php">course</a>
                    <a href="./forum_pengajar.php">forum</a>
                <?php }else{ ?>
                    <a href="./siswa/home.php">home</a>
                    <a href="./siswa/course.php">course</a>
                    <a href="./forum_siswa.php">forum</a>
                <?php } ?>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <div class="form-container">
            <h3>Add a Comment</h3>
            <form action="add_comment.php" method="post" autocomplete="off">
                <input type="hidden" name="id_postingan" value="<?= $id_postingan; ?>"> <!-- Menyimpan ID postingan -->
                <textarea id="konten" name="konten" placeholder="Write your comment" required></textarea>
                <button type="submit" name="submit">Post</button>
            </form>
        </div>
    </div>
    <div class="second-container" style="border: 1px solid #ccc; padding: 20px; margin-left: 10px; margin-right: 50px; margin-top: 20px; border-radius: 10px; background-color: #f9f9f9;">
        <div class="comments-container">
            <h3>Comments</h3>
            <?php while ($komentar = pg_fetch_assoc($data_komentar)): ?>
                <div class="comment" style="border: 1px solid #ddd; padding: 10px; margin-top: 10px; border-radius: 5px; background-color: #ffffff;">
                    <p><strong><?= htmlspecialchars($komentar['nama_pembuat']); ?></strong> (<?= $komentar['waktu_dibuat']; ?>)</p>
                    <p><?= htmlspecialchars($komentar['komentar']); ?></p>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html>
