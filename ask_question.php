<?php
// Konfigurasi database PostgreSQL
$host = "localhost";
$dbname = "forum";
$user = "postgres"; // Sesuaikan dengan username PostgreSQL
$password = "password"; // Masukkan password PostgreSQL

// Membuat koneksi
$conn = pg_connect("host=$host dbname=$dbname user=$user password=$password");

// Memeriksa koneksi
if (!$conn) {
    die("Connection failed: " . pg_last_error());
}
session_start();

if (isset($_POST["submit"])) {
    // Debug: cek data yang diterima
    var_dump($_POST); // Periksa isi $_POST
    
    $topic = htmlspecialchars($_POST['topic']);
    $content = htmlspecialchars($_POST['new-tweet-content']);
    
    // Menyimpan pertanyaan ke database
    $query = "INSERT INTO questions (topic, content) VALUES ('$topic', '$content')";
    $result = pg_query($conn, $query);
    
    if ($result) {
        header("Location: forum.html");
    } else {
        echo "Pertanyaan tidak berhasil diupload";
    }
    
}

// Menutup koneksi
pg_close($conn);
?>
