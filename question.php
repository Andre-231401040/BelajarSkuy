<?php 
require "function.php";
session_start();

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

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask a Question</title>
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
    </header>
    
    <div class="main-container">
        <div class="ask-question-container">
            <button class="ask-question">Ask Question</button>
        </div>
        <!-- Side Navbar -->
        <div class="side-navbar">
            <ul>
                
                <li><img src="images/discussion.png" alt="discussion" class="icon"><span onclick="showAll()">All Discussion</span></li>
                <li><img src="images/newpost.png" alt="discussion" class="icon"><span onclick="showNewPosts()">New Posts</span></li>
                <li><img src="images/myposts.png" alt="discussion" class="icon"><span onclick="showMyPosts()">My Posts</span></li>
                <li><img src="images/save.png" alt="discussion" class="icon"><span onclick="showSavedPosts()">Saved Posts</span></li>
            </ul>
        </div>

        <div class="form-container">
            <form action="ask_question.php?status=<?= $status; ?>" method="post" autocomplete="off">
                <input type="text" id="topik" name="topik" placeholder="Topic Discussion" required>
                <textarea id="konten" name="konten" placeholder="Write your question" required></textarea>
                <button type="submit" name="submit">Post</button>
            </form>
        </div>
    
    </body>
    </html>
