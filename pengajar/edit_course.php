<?php 
require "../function.php";
session_start();

$id_pengajar = $_SESSION["id"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama = $data_pengajar["nama"];
$gambar = $data_pengajar["foto_profil"];

if(isset($_SESSION["id_kursus"])){
    $id_kursus = $_SESSION["id_kursus"];
}else{
    if(isset($_POST["submit"])){
        $judul = $_POST["judul"];
        $deskripsi = $_POST["deskripsi"];
        $kategori = $_POST["kategori"];
        $harga = $_POST["harga"];
        $tugas = $_POST["tugas"];
        $kuis = $_POST["kuis"];
        $nama_file_pdf = $_FILES["materi_pdf"]["name"];
        $tmp_pdf = $_FILES["materi_pdf"]["tmp_name"];
        $ekstensi_valid = ["pdf", "mp4"];

        if($_FILES["materi_video"]["size"] !== 0){
            $nama_file_video = $_FILES["materi_video"]["name"];
            $error_video = $_FILES["materi_video"]["error"];
            $tmp_video = $_FILES["materi_video"]["tmp_name"];

            $ekstensi_pdf = explode(".", $nama_file_pdf);
            $ekstensi_pdf = strtolower(end($ekstensi_pdf));
            $ekstensi_video = explode(".", $nama_file_video);
            $ekstensi_video = strtolower(end($ekstensi_video));

            if(!in_array($ekstensi_pdf, $ekstensi_valid) || !in_array($ekstensi_video, $ekstensi_valid)){
                echo "<script>alert('Format file harus pdf untuk materi pdf dan mp4 untuk materi video')</script>";
            }else{
                $materi_pdf = uniqid();
                $materi_pdf .= "." . $ekstensi_pdf;
                $materi_video = uniqid();
                $materi_video .= "." . $ekstensi_video;
                move_uploaded_file($tmp_pdf, "../materi/pdf/" . $materi_pdf);
                move_uploaded_file($tmp_video, "../materi/video/" . $materi_video);

                $query = "INSERT INTO kursus (judul, deskripsi, kategori, harga, materi_pdf, materi_video, tugas, kuis, id_pengajar) VALUES ('$judul', '$deskripsi', '$kategori', $harga, '$materi_pdf', '$materi_video', '$tugas', '$kuis', $id_pengajar)";
                $result = pg_query($con, $query);

                if(!$result){
                    echo "<script>alert('Kursus gagal ditambah')</script>";
                }else{
                    $successAdd = true;
                    header("refresh: 2; course.php");
                }
            }
        }else{
            $ekstensi_pdf = explode(".", $nama_file_pdf);
            $ekstensi_pdf = strtolower(end($ekstensi_pdf));

            if(!in_array($ekstensi_pdf, $ekstensi_valid)){
                echo "<script>alert('Format file harus pdf untuk materi pdf')</script>";
            }else{
                $materi_pdf = uniqid();
                $materi_pdf .= "." . $ekstensi_pdf;
                move_uploaded_file($tmp_pdf, "../materi/pdf/" . $materi_pdf);

                $query = "INSERT INTO kursus (judul, deskripsi, kategori, harga, materi_pdf, tugas, kuis, id_pengajar) VALUES ('$judul', '$deskripsi', '$kategori', $harga, '$materi_pdf', '$tugas', '$kuis', $id_pengajar)";
                $result = pg_query($con, $query);

                if(!$result){
                    echo "<script>alert('Kursus gagal ditambah')</script>";
                }else{
                    $successAdd = true;
                    header("refresh: 2; course.php");
                }
            }
        }

    }
}

pg_close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Edit Course </title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Quicksand Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet">
    <!--Style-->
    <link rel="stylesheet" href="styles/edit_course.css" />
</head>
<body>
    <header>
        <nav>
            <a href="./edit_profil.php" class="profil">
                <?php if($gambar != null){ ?>
                    <img src="../images/pengajar/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
                <?php }else{ ?>
                    <img src="../images/pengajar/foto_profil/foto-1.jpg" alt="foto profil default">
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
                    <a href="">Forum</a>
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if(isset($id_kursus)) { ?>
            <form action="edit_course.php" method="post" enctype="multipart/form-data" autocomplete="off">
                <label for="judul">Judul
                    <input type="text" id="judul" name="judul" required value="<?= $judul; ?>">
                </label>
                <label for="deskripsi">Deskripsi
                    <textarea name="deskripsi" id="deskripsi" required><?= $deskripsi; ?></textarea>
                </label>
                <label for="kategori">Kategori
                    <input type="text" id="kategori" name="kategori" required value="<?= $kategori; ?>">
                </label>
                <label for="harga">Harga
                    <input type="number" id="harga" name="harga" required value="<?= $harga; ?>">
                </label>
                <label for="materi_pdf">Materi (PDF)
                    <input type="file" id="materi_pdf" name="materi_pdf" required value="<?= $materi_pdf; ?>">
                </label>
                <label for="materi_video">Materi (Video)
                    <input type="file" id="materi_video" name="materi_video" value="<?= $materi_video; ?>">
                </label>
                <label for="tugas">Tugas
                    <input type="text" id="tugas" name="tugas" value="<?= $tugas; ?>">
                </label>
                <label for="kuis">Kuis
                    <input type="text" id="kuis" name="kuis" value="<?= $kuis; ?>">
                </label>
                <?php if(isset($successAdd)) : ?>
                    <p class="berhasil-tambah">Kursus berhasil ditambahkan</p>
                <?php endif; ?>
                <button type="submit" name="submit">Selesai</button>
            </form>
        <?php } else { ?>
            <form action="edit_course.php" method="post" enctype="multipart/form-data" autocomplete="off">
                <label for="judul">Judul
                    <input type="text" id="judul" name="judul" required>
                </label>
                <label for="deskripsi">Deskripsi
                    <textarea name="deskripsi" id="deskripsi" required></textarea>
                </label>
                <label for="kategori">Kategori
                    <input type="text" id="kategori" name="kategori" required>
                </label>
                <label for="harga">Harga
                    <input type="number" id="harga" name="harga" required>
                </label>
                <label for="materi_pdf">Materi (PDF)
                    <input type="file" id="materi_pdf" name="materi_pdf" required>
                </label>
                <label for="materi_video">Materi (Video)
                    <input type="file" id="materi_video" name="materi_video">
                </label>
                <label for="tugas">Tugas
                    <input type="text" id="tugas" name="tugas">
                </label>
                <label for="kuis">Kuis
                    <input type="text" id="kuis" name="kuis">
                </label>
                <?php if(isset($successAdd)) : ?>
                    <p class="berhasil-tambah">Kursus berhasil ditambahkan</p>
                <?php endif; ?>
                <button type="submit" name="submit">Selesai</button>
            </form>
        <?php } ?>
    </main>
</body>
</html>
