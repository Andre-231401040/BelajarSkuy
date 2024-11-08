<?php 
  require "function.php";
  session_start();
  $data_course = pg_query($con, "SELECT * FROM kursus ORDER BY jumlah_siswa DESC LIMIT 3");
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>BelajarSkuy</title>
    <link rel="icon" href="./images/logo.png" sizes="32x32" type="image/png" />
    <!-- Fonts -->
    <!-- Racing Sans One -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet" />
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="styles.css" />
  </head>
  <body>
    <header>
      <nav>
        <h1>BelajarSkuy</h1>
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="container">
          <div class="navigation">
            <a href="#about">Tentang</a>
            <a href="#courses">Kursus</a>
            <a href="#social-media">Kontak</a>
          </div>
          <div class="login_register">
            <a href="./home/login.php" class="login">Masuk</a>
            <div class="register">
              <button href="" class="register-button">Daftar</button>
              <div class="register-option isHidden">
                <a href="./home/register_student.php">Sebagai Murid</a>
                <a href="./home/register_teacher.php">Sebagai Pengajar</a>
              </div>
            </div>
          </div>
        </div>
      </nav>
      <div class="jumbotron">
        <div class="text">
          <header>
            <h2>Ayo</h2>
            <h2 class="highlight">E-Learning</h2>
            <h2>di Rumah Anda</h2>
          </header>
          <p>Tingkatkan keterampilan Anda dengan kursus online interaktif. Akses materi berkualitas, mentor berpengalaman, dan komunitas belajar yang siap mendukung perjalanan Anda. Mulailah belajar hari ini dan raih impian Anda!</p>
          <div class="link">
            <div class="apply">
              <button class="apply-button">Daftar Sekarang</button>
              <div class="apply-option isHidden">
                <a href="./home/register_student.php">Sebagai Murid</a>
                <a href="./home/register_teacher.php">Sebagai Pengajar</a>
              </div>
            </div>
            <a href="#about" class="readmore">Baca Selengkapnya</a>
          </div>
        </div>
        <img src="./images/vektor.png" alt="gambar vektor dua orang sedang berbicara" />
      </div>
    </header>
    <main>
      <a href="./home/faq.html" class="faq"><img src="./images/Main Logo.png" alt="logo faq" /></a>
      <article id="about">
        <div class="about-container">
          <h2>Tentang Kami</h2>
          <p>
          Kami adalah platform kursus online yang berdedikasi untuk membantu Anda mengembangkan keterampilan dan pengetahuan di berbagai bidang, mulai dari teknologi hingga kreativitas. Dengan akses ke materi terbaru dan mentor profesional, kami percaya bahwa setiap orang berhak untuk belajar tanpa batasan waktu dan tempat. Misi kami adalah menciptakan pengalaman belajar yang fleksibel, interaktif, dan berkualitas, sehingga Anda dapat meraih tujuan karier dan pribadi dengan lebih percaya diri.
          </p>
          <div class="image">
            <img src="./images/development.jpg" alt="gambar vektor pengembangan aplikasi" />
            <img src="./images/science.jpg" alt="gambar vektor sains" />
            <img src="./images/business.jpg" alt="gambar vektor bisnis" />
          </div>
        </div>
      </article>
      <article id="courses">
        <div class="courses-container">
          <h2>Kursus Paling Populer</h2>
          <div class="course-container">
            <?php while($row = pg_fetch_assoc($data_course)) { ?>
            <div class="course"> 
              <img src="./thumbnail/<?= $row["thumbnail"] ?>" alt="gambar kelas <?= $row["judul"] ?>" />
              <h3><?= $row["judul"] ?></h3>
              <p>Mentor : 
                <?php 
                  $query = pg_fetch_assoc(pg_query($con,"SELECT * FROM pengajar WHERE id = {$row["id_pengajar"]}"));
                ?>
                <?= $query["nama"] ?>
              </p>
              <p><?= $row["jumlah_siswa"]?> murid terdaftar</p>
              <p>Rp<?= $row["harga"] ?></p>
              <?php if ($row["harga"] == 0 ) { ?>
                <a href="home/login.php">Mulai</a>
              <?php } else { ?>
                <a href="home/login.php">Daftar</a>
              <?php } ?>
            </div>
            <?php }; ?>
          </div>
        </div> 
      </article>
    </main>
    <footer>
      <div class="nama-website">
        <img src="./images/logo.png" alt="logo belajarskuy" />
        <h2>BelajarSkuy</h2>
      </div>
      <div id="social-media">
        <h2>Hubungi Kami</h2>
        <div class="gambar">
          <a href="mailto:andrelim806@gmail.com" target="_blank"><img src="./images/gmail.png" alt="logo gmail" /></a>
          <a href="https://www.instagram.com/dree_lim" target="_blank"><img src="./images/instagram.png" alt="logo instagram" /></a>
          <a href="https://wa.me/6281361926580" target="_blank"><img src="./images/whatsapp.png" alt="logo whatsapp" /></a>
        </div>
      </div>
    </footer>
    <script>
      const registerButton = document.querySelector(".register-button");
      const registerOption = document.querySelector(".register-option");
      registerButton.addEventListener("click", () => {
        if (registerOption.classList.contains("isHidden")) {
          registerOption.classList.remove("isHidden");
        } else {
          registerOption.classList.add("isHidden");
        }
      });

      const applyButton = document.querySelector(".apply-button");
      const applyOption = document.querySelector(".apply-option");
      applyButton.addEventListener("click", () => {
        if (applyOption.classList.contains("isHidden")) {
          applyOption.classList.remove("isHidden");
        } else {
          applyOption.classList.add("isHidden");
        }
      });

      const hamburgerBtn = document.querySelector(".hamburger");
      const navList = document.querySelector(".container");
      hamburgerBtn.addEventListener("click", () => {
        if(navList.classList.contains("display")){
          navList.classList.remove("display");
        }else{
          navList.classList.add("display");
        }
      });
    </script>
  </body>
</html>

