<?php 
require "../function.php";
session_start();

if(!isset($_SESSION["id_pengajar"])){
    header("Location: ../home/login.php");
}

$id_pengajar = $_SESSION["id_pengajar"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama = $data_pengajar["nama"];
$email = $data_pengajar["email"];
$gambar = $data_pengajar["foto_profil"];

$kursus = pg_query($con, "SELECT * FROM kursus WHERE id_pengajar = $id_pengajar");
$jumlah_siswa = pg_fetch_assoc(pg_query($con, "SELECT SUM(jumlah_siswa) FROM kursus WHERE id_pengajar = $id_pengajar"))["sum"];
$total_pendapatan = pg_fetch_assoc(pg_query($con, "SELECT SUM(harga * jumlah_siswa) FROM kursus WHERE id_pengajar = $id_pengajar"))["sum"];
$data_gaji_ditarik = pg_query($con, "SELECT * FROM gaji_ditarik where id_pengajar = $id_pengajar");

if(pg_affected_rows($data_gaji_ditarik) === 0){
    $gaji_ditarik = 0;
}else{
    $gaji_ditarik = pg_fetch_assoc($data_gaji_ditarik)["jumlah"];
}

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?> | Home</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Fonts -->
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="./styles/home.css" />
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
            </div>
        </a>
        <div class="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
        <div class="container">
            <div class="navigation">
                <a href="./home.php">Beranda</a>
                <a href="./course.php">Kursus</a>
                <a href="../forum_pengajar.php">Forum</a>
            </div>
        </div>
    </nav>
    </header>

    <main>
        <h1 style="color: #2E7DBF;">Selamat Datang, <?= $nama; ?></h1>
        <div class="content">
            <div class="container-rectangle">
                <div class="rectangle">
                    <h2 class="label">Jumlah Murid</h2>
                    <?php if(!is_null($jumlah_siswa)){ ?>
                        <p class="value"><?= $jumlah_siswa; ?></p>
                    <?php }else{ ?>
                        <p class="value">0 siswa</p>
                    <?php } ?>
                </div>
                <div class="rectangle">
                    <h2 class="label">Pendapatan</h2>
                    <?php if(!is_null($total_pendapatan)){ ?>
                        <p>Rp<?= $total_pendapatan - $gaji_ditarik; ?></p>
                    <?php }else{ ?>
                        <p>Rp0</p>
                    <?php } ?>
                    <form action="tarik_gaji.php" method="post">
                        <input type="hidden" name="nama" value="<?= $nama; ?>">
                        <input type="hidden" name="email" value="<?= $email; ?>">
                        <input type="hidden" name="pendapatan" value="<?= $total_pendapatan - $gaji_ditarik; ?>">
                        <button id="tarik" type="submit" name="tarik">Tarik</button>
                    </form>
                </div>
            </div>
            <div class="kursus">
                <?php if(pg_affected_rows($kursus) !== 0){ ?>
                    <h2>Kursus terpopuler anda</h2>
                    <div class="card-container">
                        <?php while($row = pg_fetch_assoc($kursus)){ ?>
                            <!-- masukkan div dengan class card -->
                            <p><?= $row["judul"]; ?></p>
                        <?php } ?>
                    </div>
                <?php }else{ ?>
                    <h2 class="label">anda belum memiliki kursus</h2>
                <?php } ?>
            </div>
        </div>     
    </main>
    
    <script>
        const hamburgerBtn = document.querySelector(".hamburger");
        const navList = document.querySelector(".container");
        hamburgerBtn.addEventListener("click", () => {
        if(navList.classList.contains("display")){
            navList.classList.remove("display");
        }else{
          navList.classList.add("display");
        }
        });

        const form = document.querySelector("form");
        const checkOutButton = document.querySelector("#tarik");
        checkOutButton.addEventListener("click", function(e){
            const formData = new FormData(form);
            const data = new URLSearchParams(formData);
            const objData = Object.fromEntries(data);
            const message = formatMessage(objData);
            console.log(message);
            window.open("https://wa.me/6281361926580?text=" + encodeURIComponent(message));
        });

        const formatMessage = (obj) => {
            return `
            Data Pengajar
            Nama: ${obj.nama}
            Email: ${obj.email}
            Pendapatan: ${obj.pendapatan}
            Metode Pembayaran: (Gopay, OVO, BCA, dll)
            Nomor Rekening atau VA: (Isi dengan nomor anda)
            `;
        };
    </script>
</body>
</html>