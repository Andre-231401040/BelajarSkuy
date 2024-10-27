<?php
require "../function.php";
session_start();

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$profil = $data_siswa["foto_profil"];

$id_course = $_SESSION["id_course"];
$data_course = pg_fetch_assoc(pg_query($con, "SELECT * FROM kursus WHERE id = $id_course"));
$id_pengajar = $data_course["id_pengajar"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama_pengajar = $data_pengajar["nama"];
$judul = $data_course["judul"];
$thumbnail = $data_course["thumbnail"];
$deskripsi = $data_course["deskripsi"];
$pdf = $data_course["materi_pdf"];
$video = $data_course["materi_video"];
$tugas = $data_course["tugas"];
$quiz = $data_course["kuis"];

pg_close(); 
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Course Name</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="styles/InsideCoursestyle.css" />
  </head>
  <body>
    <header>
    <nav>
            <a href="./profil_siswa.php" class="profil">
                <?php if($profil != null){ ?>
                    <img src="../images/foto_profil/<?= $profil; ?>" alt="foto profil <?= $nama; ?>">
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
                    <a href="./home.php">Home</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="./course.php">Course</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="../forum_siswa.php">Forum</a>
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
      <h1 style="margin: 20px"><?= $judul ?></h1>
      <div class="container-namapengajar">
        <div class="circle"></div>
        <h2><?= $nama_pengajar?></h2>
      </div>
      <div class="container-main">
        <div class="container-gambar">
          <img src="../thumbnail/<?= $thumbnail ?>" class="gambarkurs">
        </div>
      </div>
      <div class="container-main2">
        <div class="container-materi">
          <h1 class="judul">Deskripsi: </h1>
          <p  class="deskripsi"><?= $deskripsi ?></p>
        </div>
        <div class="container-materi">
          <h1 class="judul">PDF: </h1>
          <?php if ($pdf != null) { ?>
            <a href="InsideCourse.php?id=<?= $row['id']?>" class="rectangle-3" id="download-pdf" style="margin: 20px">Download</a>
          <?php } ?>
        </div>
        <div class="container-materi">
          <h1 class="judul">Video: </h1>
          <?php if ($video != null) { ?>
          <video controls src="../materi/video/<?= $video ?>" class="video" style="margin: 20px"></video>
          <?php } else {?>
            <p style="margin: 30px">Tidak ada Video</p>
          <?php } ?>
        </div>
        <div class="container-materi">
          <h1 class="judul">Tugas: </h1>
          <?php if ($tugas != null) { ?>
            <a href="<?= $tugas ?>" id="tugas" style="margin: 30px">Buka Link ini</a>
          <?php } else {?>
            <p style="margin: 30px">Tidak ada Tugas</p>
          <?php } ?>
        </div>
        <div class="container-materi">
          <h1 class="judul">Quiz: </h1>
          <?php if ($quiz != null) { ?>
            <a href="<?= $quiz ?>" id="kuis" style="margin: 30px">Buka Link ini</a>
          <?php } else {?>
            <p style="margin: 30px">Tidak ada kuis</p>
          <?php } ?>
        </div>
      </div>
    </main>
    <script>
      document.getElementById('download-pdf').addEventListener('click', function(){
        const downloadLink = document.createElement('a');
        downloadLink.href = '../materi/pdf/<?= $pdf ?>'; 
        downloadLink.download = '<?= $judul ?>.pdf'; 
        downloadLink.click();
      });
      document.getElementById('kuis').addEventListener('click', function(){
        window.location.href = '<?= $quiz ?>';
      });
      document.getElementById('tugas').addEventListener('click', function(){
        window.location.href = '<?= $tugas ?>';
      });
    </script>
  </body>
</html>
