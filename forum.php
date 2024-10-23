<?php 
require "function.php";
session_start();

if(isset($_SESSION["id_pengajar"])){
    $id_pengajar = $_SESSION["id_pengajar"];
    $data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
    $nama = $data_pengajar["nama"];
    $gambar = $data_pengajar["foto_profil"];
}else if(isset($_SESSION["id_siswa"])){
    $id_siswa = $_SESSION["id_siswa"];
    $data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
    $nama = $data_siswa["nama"];
    $gambar = $data_siswa["foto_profil"];
}

$data_pertanyaan = pg_query($con, "SELECT * FROM pertanyaan");

$dateNow = new DateTime();

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="stylesforum.css">
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
            <a href="question.php"><button class="ask-question">Ask Question</button></a>
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

        <div class="container">
            <?php while($row = pg_fetch_assoc($data_pertanyaan)){ ?>
                <div class="tweet" data-author="Hana" data-time="6h ago" data-saved="false">
                    <div class="tweet-header">
                        <div class="topic"><?= $row["topik"]; ?></div> <!-- Topic di atas -->
                        <div class="profile-tweet">
                            <img src="./images/foto_profil/<?= $row["foto_pembuat"]; ?>" alt="foto profil <?= $row["nama_pembuat"]; ?>" class="profile-pic-tweet">
                            <div class="user-info">
                            <span class="username"><?= $row["nama_pembuat"]; ?></span><br>
                            <span class="time"><?php 
                                $dateCreated = date_create($row["waktu_dibuat"]);
                                $diff = date_diff($dateCreated, $dateNow);
                                if($diff->h - 4 < 24){
                                    echo $diff->h - 4 . "h ago";
                                }else{
                                    echo $diff->d . "d ago";
                                }
                            ?></span>
                            </div>
                        </div>
                    </div>
                    <div class="tweet-content">
                        <p><?= $row["konten"]; ?></p>
                    </div>
                    <div class="tweet-footer">
                        <div class="left-icons">
                            <img src="images/chat-bubble.png" alt="Comment Icon" class="footer-icon" onclick="comment()">
                            <img src="images/more.png" alt="Like Icon" class="footer-icon" onclick="more()">
                        </div>
                        <div class="right-icons">
                            <img src="images/save.png" alt="Save Icon" class="footer-icon" onclick="save(this)">
                        </div>
                    </div>
                </div>
            <?php } ?>
    </div>

    <!-- Link to external JavaScript file -->
    <script src="scripts.js"></script>
</body>
</html>