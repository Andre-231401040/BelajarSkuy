<?php
require "../function.php";
session_start();

if(!isset($_SESSION["id_siswa"])){
    header("Location: ../home/login.php");
}

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$profil = $data_siswa["foto_profil"];
$email = $data_siswa["email"];

$id = $_GET["id"];
$_SESSION["id"] = $id;
$data_course = pg_fetch_assoc(pg_query($con, "SELECT * FROM kursus WHERE id = $id"));
$thumbnail = $data_course["thumbnail"];
$nama_course = $data_course["judul"];
$harga_course = $data_course["harga"];
$jumlah_murid = $data_course["jumlah_siswa"];
$id_pengajar = $data_course["id_pengajar"];
$data_pengajar = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
$nama_pengajar = $data_pengajar["nama"];
pg_close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <script type="text/javascript"
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="SB-Mid-client-_S8Yz3vjKJxC6Bjr"></script>
    <link rel="stylesheet" href="styles/PayStyle.css">
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
          </div>
        </a>
        <div class="hamburger">
          <span></span>
          <span></span>
          <span></span>
        </div>
        <div class="container">
          <div class="navigation">
            <a href="home.php">Beranda</a>
            <a href="course.php">Kursus</a>
            <a href="../forum_siswa.php">Forum</a>
          </div>
        </nav>
    </header>
    <main>
        <div class="container-payment">
            <h1 class="judul"> Pembayaran </h1> 
            <img class = "thumbnail" src = "../thumbnail/<?= $thumbnail ?>" alt = "<?= $nama_course ?>">
            <div class = "rectangle judulcourse"> <?= $nama_course ?> </div>
            <div class = "rectangle"> <?= $nama_pengajar ?> </div> 
            <div class = "rectangle"> <?= $jumlah_murid?> murid terdaftar </div>
            <div class = "rectangle"> Rp<?= $harga_course ?> </div>         
            <div class="container-linktabel"> 
            <form> <button class="rectangle-3" type="submit" id="pay" value="checkout"> Bayar </button></form>
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
        var payButton = document.getElementById('pay');
        payButton.addEventListener('click', async function (e) {
            e.preventDefault();
            const data = new FormData();
            try{
                const response = await fetch('midtrans.php', {
                method : 'POST',
                body : data,
            });
            const token = await response.text();
            window.snap.pay(token, {
                onSuccess: function(result){
                    window.location.href = "pembayaran.php";
                },
            });
            }catch (err) {
                console.log(err.message);
            }
        });
    </script>
</body>
</html>