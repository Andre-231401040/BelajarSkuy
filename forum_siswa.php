<?php 
require "function.php";
session_start();

if(isset($_SESSION["id_siswa"])){
    $_SESSION["isFound"] = "student";
    $id_siswa = $_SESSION["id_siswa"];
    $data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
    $email = $data_siswa["email"];
    $nama = $data_siswa["nama"];
    $gambar = $data_siswa["foto_profil"];
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
    <!-- Link to external CSS file -->
    <link rel="stylesheet" href="stylesforum.css">
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
                <a href="./siswa/home.php">home</a>
                <a href="./siswa/course.php">course</a>
                <a href="./forum_siswa.php">forum</a>
            </nav>
    </header>
    
    <div class="main-container">
        <div class="ask-question-container">
            <a href="question.php?email=<?= $email; ?>"><button class="ask-question">Ask Question</button></a>
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
            <?php 
            while($row = pg_fetch_assoc($data_pertanyaan)){
                $dateCreated = new DateTime($row["waktu_dibuat"]);
                $dateNow = new DateTime(); // Waktu sekarang
                $diff = $dateNow->diff($dateCreated); // Menghitung selisih waktu
                $isNew = ($diff->d < 1); // Selisih hari kurang dari 1 (kurang dari 24 jam)
                $isNewMinute = ($diff->h == 0 && $diff->i == 0 && $diff->s < 60); // Cek jika umur postingan kurang dari 1 menit
            ?>
        <div class="tweet <?= $isNew ? 'new-post' : ''; ?>" data-time="<?= $diff->h; ?>h ago" data-user-id="<?= $row['id']; ?>">
        <div class="tweet-header">
            <div class="topic"><?= $row["topik"]; ?></div>
            <div class="profile-tweet">
                <?php if(($row["foto_pembuat"]) != ""){ ?>
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
                <a href="comments.php?id=<?= $row['id']; ?>&email=<?= $email; ?>">
                    <img src="images/chat-bubble.png" alt="Comment Icon" class="footer-icon">
                </a>
            </div>
            <div class="right-icons">
                <img src="images/save.png" alt="Save Icon" class="footer-icon" onclick="save(this)">
            </div>
        </div>
    </div>
<?php } ?>
    </div>

    <div id="myPostsContainer" class="container" style="display: none;">
            <?php 
            while($row = pg_fetch_assoc($data_my_posts)){
                $dateCreated = new DateTime($row["waktu_dibuat"]);
                $diff = (new DateTime())->diff($dateCreated);
                $isNew = ($diff->d < 1);
                $isNewMinute = ($diff->h == 0 && $diff->i == 0 && $diff->s < 60);
            ?>
            <div class="tweet <?= $isNew ? 'new-post' : ''; ?>">
                <div class="tweet-header">
                    <div class="topic"><?= $row["topik"]; ?></div>
                    <div class="profile-tweet">
                        <img src="./images/foto_profil/<?= $row["foto_pembuat"]; ?>" alt="foto profil <?= $row["nama_pembuat"]; ?>" class="profile-pic-tweet">
                        <div class="user-info">
                            <span class="username"><?= $row["nama_pembuat"]; ?></span><br>
                            <span class="time"><?php 
                                $dateCreated = date_create($row["waktu_dibuat"]);
                                $diff = date_diff($dateCreated, $dateNow);
                                if($diff->h < 24){
                                    echo $diff->h . "h ago";
                                }else{
                                    echo $diff->d . "d ago";
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
                <a href="comments.php?id=<?= $row['id']; ?>">
                    <img src="images/chat-bubble.png" alt="Comment Icon" class="footer-icon">
                </a>
            </div>
            <div class="right-icons">
                <img src="images/save.png" alt="Save Icon" class="footer-icon" onclick="save(this)">
            </div>
        </div>

<?php } ?>
    </div>

    <!-- Link to external JavaScript file -->
    <script src="scripts.js"></script>
</body>
</html>