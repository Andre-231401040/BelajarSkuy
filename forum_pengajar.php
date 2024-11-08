<?php 
require "function.php";
session_start();

if(!isset($_SESSION["id_pengajar"])){
    header("Location: home/login.php");
}

if(isset($_SESSION["id_pengajar"])){
    $_SESSION["isFound"] = "teacher";
    $id_pengajar = $_SESSION["id_pengajar"];
    $data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
    $email = $data_pengajar["email"];
    $nama = $data_pengajar["nama"];
    $gambar = $data_pengajar["foto_profil"];
}else{
    header("Location: home/login.php");
}

$data_pertanyaan = pg_query($con, "SELECT * FROM pertanyaan");

date_default_timezone_set("Asia/Jakarta");
$dateNow = new DateTime();

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="icon" href="./images/logo.png" sizes="32x32" type="image/png" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="stylesforum.css" />
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
                    <div class="underline"></div>
                </div>
            </a>
            <ul>
                <li>
                    <a href="./pengajar/home.php">Home</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="./pengajar/course.php">Course</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="../forum_pengajar.php">Forum</a>
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>
    
    <div class="main-container">
        <div class="ask-question-container">
            <a href="question.php?id=<?= $email; ?>"><button class="ask-question">Ask Question</button></a>
        </div>
        <!-- Side Navbar -->
        <div class="side-navbar">
            <ul>
                <li><a href="./forum_pengajar.php"><img src="images/discussion.png" alt="discussion" class="icon">All Discussion</a></li>
                <li><a href="./new_post.php"><img src="images/newpost.png" alt="discussion" class="icon">New Posts</a></li>
                <li><a href="./my_post.php"><img src="images/myposts.png" alt="discussion" class="icon">My Posts</a></li>
                <li><a href="./saved_post.php"><img src="images/save.png" alt="discussion" class="icon">Saved Posts</a></li>
            </ul>
        </div>

        <div class="container">
            <?php 
            while($row = pg_fetch_assoc($data_pertanyaan)){
                $id_postingan = $row["id"];
                $dateCreated = date_create($row["waktu_dibuat"]);
                $diff = date_diff($dateCreated, $dateNow); // Menghitung selisih waktu
                $isNewMinute = ($diff->h == 0 && $diff->i == 0 && $diff->s < 60); // Cek jika umur postingan kurang dari 1 menit
            ?>
                <div class="tweet <?= $isNew ? 'new-post' : ''; ?>" data-time="<?= $diff->h; ?>h ago" data-user-id="<?= $row['id']; ?>">
                    <div class="tweet-header">
                        <div class="topic"><?= $row["topik"]; ?></div>
                        <div class="profile-tweet">
                            <?php if($row["foto_pembuat"] != ""){ ?>
                                <img src="./images/foto_profil/<?= $row["foto_pembuat"]; ?>" alt="foto profil <?= $row["nama_pembuat"]; ?>" class="profile-pic-tweet">
                            <?php }else{ ?>
                                <img src="./images/foto_profil/foto-1.jpg" alt="foto profil default" class="profile-pic-tweet">
                            <?php } ?>
                            <div class="user-info">
                            <span class="username"><?= $row["nama_pembuat"]; ?></span><br>
                            <span class="time">
                            <?php 
                                // Penghitungan waktu yang ditampilkan
                                if ($isNewMinute) {
                                    echo "new"; // Jika kurang dari 1 menit
                                } else if ($diff->h < 1) {
                                    echo $diff->i . "m ago"; // Jika kurang dari 1 jam
                                } else if ($diff->d < 1) {
                                    echo $diff->h . "h ago"; // Jika kurang dari 1 hari
                                } else {
                                    echo $diff->d . "d ago"; // Jika lebih dari 1 hari
                                }
                                ?>
                            </span>
                            </div>
                        </div>
                    </div>
                    <div class="tweet-content">
                        <p><?= $row["konten"]; ?></p>
                    </div>
                    <div class="tweet-footer">
                    <div class="left-icons">
                            <a href="comments.php?id=<?= $id_postingan; ?>">
                                <img src="images/chat-bubble.png" alt="Comment Icon" class="footer-icon">
                            </a>
                        </div>
                        <div class="right-icons">
                            <?php if(pg_affected_rows(pg_query($con, "SELECT * FROM posting_disimpan WHERE id_postingan = $id_postingan AND email_penyimpan = '$email'")) === 0){ ?>
                                <a href="./save_post.php?id=<?= $id_postingan; ?>&email_penyimpan=<?= $email; ?>&jalur=forum_pengajar"><img src="images/save.png" alt="Save Icon" class="footer-icon"></a>
                            <?php }else{ ?>
                                <a href="./delete_saved.php?id=<?= $id_postingan; ?>&email_penyimpan=<?= $email; ?>&jalur=forum_pengajar"><img src="images/bookmark.png" alt="Saved Icon" class="footer-icon"></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
</body>
</html>