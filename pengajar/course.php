<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course</title>
    <!-- Quicksand Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles/course.css" />
  </head>
  <body>
    <header>
      <div class="pengajar-card">
        <div class="profil-circle"></div>
        <div>
          <div class="nama">Nama Pengajar</div>
          <div class="underline"></div>
        </div>
      </div>

      <nav>
        <ul>
          <li><a href="home.php">home</a></li>
          <li><a href="course.php" class="active">course</a></li>
          <li><a href="forum.php">forum</a></li>
        </ul>
      </nav>
    </header>

    <a href="#" class="add-course"> + Kursus</a>

    <div class="course-container">
      <h2 style="visibility: hidden">Courses</h2>
      <!-- Menyembunyikan h2 tapi tetap menjaga ruang -->
      <div class="course-list">
        <div class="course-card">
          <img src="../images/finance.jpg" alt="kursus 1" />
          <h2>Kursus 1</h2>
          <div class="course-info">
            <p>Banyak Siswa</p>
            <p>Status Kursus</p>
            <p>Harga Kursus</p>
          </div>
        </div>
        <div class="course-card">
          <img src="../images/physics.jpg" alt="kursus 2" />
          <h2>Kursus 2</h2>
          <div class="course-info">
            <p>Banyak Siswa</p>
            <p>Status Kursus</p>
            <p>Harga Kursus</p>
          </div>
        </div>
        <div class="course-card">
          <img src="../images/business.jpg" alt="kursus 3" />
          <h2>Kursus 3</h2>
          <div class="course-info">
            <p>Banyak Siswa</p>
            <p>Status Kursus</p>
            <p>Harga Kursus</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
