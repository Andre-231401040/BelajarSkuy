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
$data_komentar = pg_query($con, "SELECT * FROM komentar WHERE id_postingan = $id_postingan");
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
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="stylesQuestions.css" />
</head>
<body>
<?php if($status === "pengajar"){ ?>
            <header>
            <nav>
                <a href="./pengajar/edit_profil.php'>" class="profil">
                    <?php if($gambar != null){ ?>
                        <img src="./images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
                    <?php }else{ ?>
                        <img src="./images/foto_profil/foto-1.jpg" alt="foto profil default">
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
                        <img src="./images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
                    <?php }else{ ?>
                        <img src="./images/foto_profil/foto-1.jpg" alt="foto profil default">
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
            <div class="form-container comments">
                <form action="add_comment.php" method="post" autocomplete="off">
                    <input type="hidden" name="id_postingan" value="<?= $id_postingan; ?>"> <!-- Menyimpan ID postingan -->
                    <textarea id="konten" name="konten" placeholder="Tuliskan komentar disini" required></textarea>
                    <button type="submit" name="submit">Kirim Komentar</button>
                </form>
            </div>
            <div class="second-container">
                <div class="comments-container">
                <h3>Komentar</h3>
                    <?php while ($komentar = pg_fetch_assoc($data_komentar)): ?>
                        <div class="comment" style="border: 1px solid #ddd; padding: 10px; margin-top: 10px; border-radius: 5px; background-color: #ffffff;">
                            <p><strong><?= htmlspecialchars($komentar['nama_pembuat']); ?></strong> (<?= $komentar['waktu_dibuat']; ?>)</p>
                            <p><?= htmlspecialchars($komentar['komentar']); ?></p>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
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
