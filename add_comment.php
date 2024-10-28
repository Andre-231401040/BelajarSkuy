<?php
require "function.php";
session_start();

// Mengambil data pengguna
if ($_SESSION["isFound"] === "student") {
    $id_siswa = $_SESSION["id_siswa"];
    $data = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
} else if ($_SESSION["isFound"] === "teacher") {
    $id_pengajar = $_SESSION["id_pengajar"];
    $data = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
} else {
    die("User not logged in.");
}

// Memeriksa koneksi
if (!$con) {
    die("Connection failed: " . pg_last_error());
}

// Memeriksa apakah form disubmit
if (isset($_POST["submit"])) {
    // Debug: cek data yang diterima
    var_dump($_POST); // Periksa isi $_POST

    $id_postingan = (int)$_POST['id_postingan']; // ID postingan
    // Pastikan untuk memeriksa apakah id_postingan tidak 0
    if ($id_postingan <= 0) {
        die("Invalid Post ID.");
    }
    $email_pembuat = $data["email"];
    $nama_pembuat = $data["nama"]; // Nama pengguna dari sesi
    $komentar = htmlspecialchars($_POST['konten']); // Konten komentar
    date_default_timezone_set("Asia/Jakarta");
    $waktu_dibuat = date("Y-m-d H:i:s"); // Waktu posting saat ini

    // Menyimpan komentar ke database
    $query = "INSERT INTO komentar (id_postingan, email_pembuat, nama_pembuat, komentar, waktu_dibuat) VALUES ($id_postingan, '$email_pembuat', '$nama_pembuat', '$komentar', '$waktu_dibuat')";
    $result = pg_query($con, $query);

    if ($result) {
        // Jika berhasil, redirect ke halaman komentar
        header("Location: comments.php?id=$id_postingan");
        exit();
    } else {
        echo "Komentar tidak berhasil diupload: " . pg_last_error($con); // Menampilkan error jika gagal
    }
}

// Menutup koneksi
pg_close($con);
?>
