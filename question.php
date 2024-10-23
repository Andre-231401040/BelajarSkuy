<?php 
require "function.php";
session_start();

if(isset($_SESSION["id_pengajar"])){
    $id_pengajar = $_SESSION["id_pengajar"];
    $data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
    $nama = $data_pengajar["nama"];
    $gambar = $data_pengajar["foto_profil"];
    $jalur = "pengajar";
}else if(isset($_SESSION["id_siswa"])){
    $id_siswa = $_SESSION["id_siswa"];
    $data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
    $nama = $data_siswa["nama"];
    $gambar = $data_siswa["foto_profil"];
    $jalur = "siswa";
}

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask a Question</title>
    <link rel="stylesheet" href="stylesQuestions.css">
</head>
<body>
    <header>
        <div class="container-header">
            <div class="rectangle">
                <img src="./images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>" class="profile-pic">
                <p class="nama"><?= $nama; ?></p>
            </div>
            <nav class="navigation">
                <a href="#home">home</a>
                <a href="#course">course</a>
                <a href="#forum" class="underline">forum</a>
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
            <form action="ask_question.php" method="post" autocomplete="off">
                <input type="text" id="topik" name="topik" placeholder="Topic Discussion" required>
                <textarea id="konten" name="konten" placeholder="Write your question" required></textarea>
                <button type="submit" name="submit">Post</button>
            </form>
        </div>
    
    </body>
    </html>
