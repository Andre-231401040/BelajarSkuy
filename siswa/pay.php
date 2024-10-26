<?php
require "../function.php";
session_start();

//ini w tes dulu pake database sendiri
$id_course = 1; //untuk sementara taruk 1 dulu biar bisa jalan phpnya
$data_course = pg_fetch_assoc(pg_query($con, "SELECT * FROM course WHERE id = $id_course"));
$nama_course = $data_course["namacourse"];
$harga_course = $data_course['hargacourse'];

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
    <link rel="stylesheet" href="PayStyle.css">
</head>
<body>
    <header>
        <div class="container">
            <div class="rectangle">
                <div class="circle"></div>
                <p class="nama">username</p>
                <nav>
                    <div class="navigation">
                    <a href="#home" class="underline">home</a>
                    <a href="#course">course</a>
                    <a href="#forum">forum</a>
                </div>
                </nav>
            </div>
        </div>
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
    <script src="pay.js"></script>
</body>
</html>