<?php
require "../function.php";
session_start();

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$no_hp = $data_siswa["nomor_handphone"];
$email = $data_siswa["email"];

$id = $_SESSION["id"]; //untuk sementara taruk 1 dulu biar bisa jalan phpnya
$data_course = pg_fetch_assoc(pg_query($con, "SELECT * FROM kursus WHERE id = $id"));
$harga_course = $data_course["harga"];
$judul_course = $data_course["judul"];
pg_close();


require_once dirname(__FILE__) . '/midtrans-php-master/Midtrans.php'; 
//SAMPLE REQUEST START HERE

// Set your Merchant Server Key
\Midtrans\Config::$serverKey = 'SB-Mid-server-vBGx_ouaHNjbsBAu9-giZBaI';
// Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
\Midtrans\Config::$isProduction = false; 
// Set sanitization on (default)
\Midtrans\Config::$isSanitized = true;
// Set 3DS transaction for credit card to true
\Midtrans\Config::$is3ds = true;


// untuk edit semua disini aja seperti harga course, nama pelanggan, dll
$params = array(
    'transaction_details' => array(
        'order_id' => rand(),
        'gross_amount' => $harga_course,
    ),
    'customer_details' => array(
        'first_name' => $nama,
        'email' => $email,
        'phone' => $no_hp,
    ),
);

$snapToken = \Midtrans\Snap::getSnapToken($params);
echo $snapToken;
?>