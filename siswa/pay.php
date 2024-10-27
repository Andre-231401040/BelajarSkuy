<?php
require "../function.php";
session_start();

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$profil = $data_siswa["foto_profil"];
$email = $data_siswa["email"];

$id = $_GET["id"];
$_SESSION["id"] = $id;
$data_course = pg_fetch_assoc(pg_query($con, "SELECT * FROM kursus WHERE id = $id"));
$nama_course = $data_course["judul"];
$harga_course = $data_course["harga"];
pg_close();
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
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
        <div class="container-payment">
            <div class="rectangle-4"><span class = "Text"><strong><?= $nama_course; ?></strong><span></div>
            <div class="rectangle-5"><span class = "Text"><strong>TOTAL : <?= $harga_course; ?></strong><span></div>           
            <div class="container-linktabel">
            <form> <button class="rectangle-3" type="submit" id="pay" value="checkout"> Pay </button></form>
            </div>
        </div>
    </main>
    <script>
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