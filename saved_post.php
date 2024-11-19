<?php 
require "function.php";
session_start();

if(!isset($_SESSION["isFound"])){
    header("Location: home/login.php");
}

if($_SESSION["isFound"] === "student"){
    $id_siswa = $_SESSION["id_siswa"];
    $data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
    $email = $data_siswa["email"];
    $nama = $data_siswa["nama"];
    $gambar = $data_siswa["foto_profil"];
    $status = "siswa";
}else if($_SESSION["isFound"] === "teacher"){
    $id_pengajar = $_SESSION["id_pengajar"];
    $data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
    $email = $data_pengajar["email"];
    $nama = $data_pengajar["nama"];
    $gambar = $data_pengajar["foto_profil"];
    $status = "pengajar";
}else{
    header("Location: home/login.php");
}

$data_pertanyaan = pg_query($con, "SELECT * FROM pertanyaan INNER JOIN posting_disimpan ON pertanyaan.id = posting_disimpan.id_postingan WHERE posting_disimpan.email_penyimpan = '$email' ORDER BY posting_disimpan.id_postingan DESC");

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
<?php if($status === "pengajar"){ ?>
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
                </div>
            </a>
            <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            </div>
            <div class="container-navbar">
            <div class="navigation">
                <a href="./pengajar/home.php">Beranda</a>
                <a href="./pengajar/course.php">Kursus</a>
                <a href="./forum_pengajar.php">Forum</a>
            </div>
            </div>
        </nav>
    </header>
    
            <?php }else{ ?>
                <header>
        <nav>
            <a href="./siswa/profil_siswa.php" class="profil">
                <?php if($gambar != null){ ?>
                    <img src="../images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
                <?php }else{ ?>
                    <img src="../images/foto_profil/foto-1.jpg" alt="foto profil default">
                <?php } ?>
                <div class="nama">
                    <h2><?= $nama; ?></h2>
                </div>
            </a>
            <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
            </div>
            <div class="container-navbar">
            <div class="navigation">
                <a href="./siswa/home.php">Beranda</a>
                <a href="./siswa/course.php">Kursus</a>
                <a href="./forum_siswa.php">Forum</a>
            </div>
            </div>
        </nav>
    </header>
    <?php } ?>
    
    <div class="main-container">
        <div class="ask-question-container">
        <a href="question.php?email=<?= $email; ?>"><button class="ask-question"><img src="images/tambah.png" alt="tambah pertanyaan" class="icon-pertanyaan"><span>Tambah Pertanyaan</span></button></a>
        </div>
        <!-- Side Navbar -->
        <div class="side-navbar">
            <ul>
                <?php if($status === "pengajar"){ ?>
                    <li><a href="./forum_pengajar.php"><img src="images/semuadiskusi.png" alt="discussion" class="icon"><span>Semua Diskusi</span></a></li>
                <?php }else{ ?>
                    <li><a href="./forum_siswa.php"><img src="images/semuadiskusi.png" alt="discussion" class="icon"><span>Semua Diskusi</span></a></li>
                <?php } ?>
                <li><a href="./new_post.php"><img src="images/diskusibaru.png" alt="discussion" class="icon"><span>Diskusi Baru</span></a></li>
                <li><a href="./my_post.php"><img src="images/pertanyaanku.png" alt="discussion" class="icon"><span>Pertanyaan Saya</span></a></li>
                <li><a href="./saved_post.php"><img src="images/tersimpan.png" alt="discussion" class="icon"><span>Tersimpan</span></a></li>
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
                                    echo $diff->i . "m yang lalu"; // Jika kurang dari 1 jam
                                } else if ($diff->d < 1) {
                                    echo $diff->h . "j yang lalu"; // Jika kurang dari 1 hari
                                } else {
                                    echo $diff->d . "h yang lalu"; // Jika lebih dari 1 hari
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
                                <a href="./save_post.php?id=<?= $id_postingan; ?>&email_penyimpan=<?= $email; ?>&jalur=saved_post"><img src="images/save.png" alt="Save Icon" class="footer-icon"></a>
                            <?php }else{ ?>
                                <a href="./delete_saved.php?id=<?= $id_postingan; ?>&email_penyimpan=<?= $email; ?>&jalur=saved_post"><img src="images/bookmark.png" alt="Saved Icon" class="footer-icon"></a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
</body>
<script> 
    const hamburgerBtn = document.querySelector(".hamburger");
      const navList = document.querySelector(".container-navbar");
      hamburgerBtn.addEventListener("click", () => {
        if(navList.classList.contains("display")){
          navList.classList.remove("display");
        }else{
          navList.classList.add("display");
        }
      });
  </script>
</html>