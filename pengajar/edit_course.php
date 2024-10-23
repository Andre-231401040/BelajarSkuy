<?php 
require "../function.php";
session_start();

$id_pengajar = $_SESSION["id_pengajar"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama = $data_pengajar["nama"];
$gambar = $data_pengajar["foto_profil"];

if(isset($_GET["id_kursus"])){
    $id_kursus = $_GET["id_kursus"];
    $data = pg_fetch_assoc(pg_query($con, "SELECT * FROM kursus WHERE id = $id_kursus"));
    $materi_video = $data["materi_video"];
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
        $nama_file_thumbnail = $_FILES["thumbnail"]["name"];
        $tmp_thumbnail = $_FILES["thumbnail"]["tmp_name"];
        $ekstensi_valid_pdf = ["pdf"];
        $ekstensi_valid_thumbnail = ["jpg", "png", "jpeg"];

        if($_FILES["materi_video"]["size"] !== 0){
            $nama_file_video = $_FILES["materi_video"]["name"];
            $tmp_video = $_FILES["materi_video"]["tmp_name"];
            $ekstensi_valid_video = ["mp4"];

            $ekstensi_pdf = explode(".", $nama_file_pdf);
            $ekstensi_pdf = strtolower(end($ekstensi_pdf));
            $ekstensi_video = explode(".", $nama_file_video);
            $ekstensi_video = strtolower(end($ekstensi_video));
            $ekstensi_thumbnail = explode(".", $nama_file_thumbnail);
            $ekstensi_thumbnail = strtolower(end($ekstensi_thumbnail));

            if(!in_array($ekstensi_pdf, $ekstensi_valid_pdf) || !in_array($ekstensi_video, $ekstensi_valid_video) || !in_array($ekstensi_thumbnail, $ekstensi_valid_thumbnail)){
                echo "<script>alert('Format file ada yang tidak sesuai')</script>";
            }else{
                $materi_pdf = uniqid();
                $materi_pdf .= "." . $ekstensi_pdf;
                $materi_video = uniqid();
                $materi_video .= "." . $ekstensi_video;
                $thumbnail = uniqid();
                $thumbnail .= "." . $ekstensi_thumbnail;
                move_uploaded_file($tmp_pdf, "../materi/pdf/" . $materi_pdf);
                move_uploaded_file($tmp_video, "../materi/video/" . $materi_video);
                move_uploaded_file($tmp_thumbnail, "../thumbnail/" . $thumbnail);

                $query = "INSERT INTO kursus (id_pengajar, judul, deskripsi, kategori, harga, materi_pdf, materi_video, tugas, kuis, thumbnail) VALUES ($id_pengajar, '$judul', '$deskripsi', '$kategori', $harga, '$materi_pdf', '$materi_video', '$tugas', '$kuis', '$thumbnail')";
                $result = pg_query($con, $query);

                if(!$result){
                    echo "<script>alert('Kursus gagal ditambah')</script>";
                }else{
                    $successAdd = true;
                }
            }
        }else{
            $ekstensi_pdf = explode(".", $nama_file_pdf);
            $ekstensi_pdf = strtolower(end($ekstensi_pdf));
            $ekstensi_thumbnail = explode(".", $nama_file_thumbnail);
            $ekstensi_thumbnail = strtolower(end($ekstensi_thumbnail));

            if(!in_array($ekstensi_pdf, $ekstensi_valid_pdf) || !in_array($ekstensi_thumbnail, $ekstensi_valid_thumbnail)){
                echo "<script>alert('Format file ada yang tidak sesuai')</script>";
            }else{
                $materi_pdf = uniqid();
                $materi_pdf .= "." . $ekstensi_pdf;
                $thumbnail = uniqid();
                $thumbnail .= "." . $ekstensi_thumbnail;
                move_uploaded_file($tmp_pdf, "../materi/pdf/" . $materi_pdf);
                move_uploaded_file($tmp_thumbnail, "../thumbnail/" . $thumbnail);

                $query = "INSERT INTO kursus (id_pengajar, judul, deskripsi, kategori, harga, materi_pdf, tugas, kuis, thumbnail) VALUES ($id_pengajar, '$judul', '$deskripsi', '$kategori', $harga, '$materi_pdf', '$tugas', '$kuis', '$thumbnail')";
                $result = pg_query($con, $query);

                if(!$result){
                    echo "<script>alert('Kursus gagal ditambah')</script>";
                }else{
                    $successAdd = true;
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
                    <a href="../forum.html">Forum</a>
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>
    <main>
        <?php if(isset($id_kursus)) { ?>
            <form action="update_course.php?id_kursus=<?= $id_kursus; ?>" method="post" enctype="multipart/form-data" autocomplete="off">
                <label for="judul">Judul
                    <input type="text" id="judul" name="judul" required value="<?= $data["judul"]; ?>">
                </label>
                <label for="deskripsi">Deskripsi
                    <textarea name="deskripsi" id="deskripsi" required><?= $data["deskripsi"]; ?></textarea>
                </label>
                <label for="kategori">Kategori
                    <input type="text" id="kategori" name="kategori" required value="<?= $data["kategori"]; ?>">
                </label>
                <label for="harga">Harga
                    <input type="number" id="harga" name="harga" required value="<?= $data["harga"]; ?>">
                </label>
                <label for="materi_pdf">Materi (PDF)
                    <input type="file" id="materi_pdf" name="materi_pdf" required>
                </label>
                <label for="materi_video">Materi (Video)
                    <input type="file" id="materi_video" name="materi_video">
                </label>
                <label for="tugas">Tugas
                    <input type="text" id="tugas" name="tugas" value="<?= $data["tugas"]; ?>">
                </label>
                <label for="kuis">Kuis
                    <input type="text" id="kuis" name="kuis" value="<?= $data["kuis"]; ?>">
                </label>
                <label for="thumbnail">Foto Thumbnail
                    <input type="file" id="thumbnail" name="thumbnail" required>
                </label>
                <?php if(isset($successEdit)) : ?>
                    <p class="berhasil-tambah">Kursus berhasil diperbarui</p>
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
                <label for="materi_video">Materi (Video / MP4)
                    <input type="file" id="materi_video" name="materi_video">
                </label>
                <label for="tugas">Tugas
                    <input type="text" id="tugas" name="tugas">
                </label>
                <label for="kuis">Kuis
                    <input type="text" id="kuis" name="kuis">
                </label>
                <label for="thumbnail">Thumbnail (jpg, png, jpeg)
                    <input type="file" id="thumbnail" name="thumbnail" required>
                </label>
                <?php if(isset($successEdit)) : ?>
                    <p class="berhasil-tambah">Kursus berhasil ditambahkan</p>
                <?php endif; ?>
                <button type="submit" name="submit">Selesai</button>
            </form>
        <?php } ?>
    </main>
</body>
</html>
