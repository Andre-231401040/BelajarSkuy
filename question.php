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

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ask a Question</title>
    <link rel="icon" href="./images/logo.png" sizes="32x32" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="stylesQuestions.css" />
</head>
<body>
<header>
    <nav>
            <a href="./pengajar/edit_profil.php" class="profil">
                <?php if($gambar != null){ ?>
                    <img src="../images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
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
                    <a href="./siswa/home.php">Home</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="./siswa/course.php">Course</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="../forum_siswa.php">Forum</a>
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>
    
    <div class="main-container">
        <div class="ask-question-container">
            <button class="ask-question">Ask Question</button>
        </div>
        <!-- Side Navbar -->
        <div class="side-navbar">
            <ul>
                <?php if($status === "pengajar"){ ?>
                    <li><a href="./forum_pengajar.php"><img src="images/discussion.png" alt="discussion" class="icon">All Discussion</a></li>
                <?php }else{ ?>
                    <li><a href="./forum_siswa.php"><img src="images/discussion.png" alt="discussion" class="icon">All Discussion</a></li>
                <?php } ?>
                <li><a href="./new_post.php"><img src="images/newpost.png" alt="discussion" class="icon">New Posts</a></li>
                <li><a href="./my_post.php"><img src="images/myposts.png" alt="discussion" class="icon">My Posts</a></li>
                <li><a href="./saved_post.php"><img src="images/save.png" alt="discussion" class="icon">Saved Posts</a></li>
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
