<?php 
require "../function.php";
session_start();

$id_pengajar = $_SESSION["id_pengajar"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama = $data_pengajar["nama"];
$gambar = $data_pengajar["foto_profil"];

$data = pg_query($con, "SELECT * FROM kursus WHERE id_pengajar = $id_pengajar");

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?= $nama; ?> | Course</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Quicksand Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!--Style-->
    <link rel="stylesheet" href="styles/course.css" />
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
                    <a href="./home.php">Home</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="./course.php">Course</a>
                    <div class="underline"></div>
                </li>
                <li>
<<<<<<< HEAD
                    <a href="../forum.html">Forum</a>
=======
                    <a href="../forum.php">Forum</a>
>>>>>>> dd01038bf4937f7d83226d2d7b0328ae8049864c
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>

    <a href="./edit_course.php" class="add-course"> + Kursus</a>

    <div class="course-container">
      <?php while($row = pg_fetch_assoc($data)){ ?>
        <div class="course-card">
          <div class="menu-container">
            <div class="menu-trigger">
              <span class="dot"></span>
              <span class="dot"></span>
              <span class="dot"></span>
            </div>
            <div class="dropdown-menu">
              <a href="edit_course.php?id_kursus=<?= $row["id"]; ?>">Edit</a>
              <a href="hapus_course.php?id_kursus=<?= $row["id"]; ?>">Hapus</a>
            </div>
          </div>
          <img src="../thumbnail/<?= $row["thumbnail"]; ?>" alt="thumbnail kursus <?= $row["judul"]; ?>">
          <h2><?= $row["judul"]; ?></h2>
          <?php if(is_null($row["jumlah_siswa"])){ ?>
            <p>0 siswa terdaftar</p>
          <?php }else{ ?>
            <p><?= $row["jumlah_siswa"]; ?> siswa terdaftar</p>
          <?php } ?>
          <p><?= $row["kategori"]; ?></p>
          <p>Rp<?= $row["harga"]; ?></p>
        </div>
      <?php } ?>
    </div>
    
    <script>
      // Menambahkan event listener ke semua elemen .menu-trigger
      document.querySelectorAll('.menu-trigger').forEach(trigger => {
        trigger.addEventListener('click', function () {
          // Ambil parent dari .menu-trigger, yaitu .menu-container
          const menuContainer = this.closest('.menu-container');
          // Toggle (aktifkan atau nonaktifkan) kelas "active" pada menu-container
          menuContainer.classList.toggle('active');
        });
      });

      // Jika ingin menutup dropdown saat mengklik di luar dropdown
      document.addEventListener('click', function (event) {
        // Jika elemen yang di-klik bukan bagian dari menu-container, maka tutup dropdown
        document.querySelectorAll('.menu-container').forEach(container => {
          if (!container.contains(event.target)) {
            container.classList.remove('active');
          }
        });
      });
    </script>
  </body>
</html>
