<?php
require "function.php";
session_start();

if($_SESSION["isFound"] === "student"){
    $id_siswa = $_SESSION["id_siswa"];
    $data = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
}

if($_SESSION["isFound"] === "teacher"){
    $id_pengajar = $_SESSION["id_pengajar"];
    $data = pg_fetch_assoc(pg_query($con, "SELECT * FROM pengajar WHERE id = $id_pengajar"));
}

// Memeriksa koneksi
if (!$con) {
    die("Connection failed: " . pg_last_error());
}

if (isset($_POST["submit"])) {
    // Debug: cek data yang diterima
    var_dump($_POST); // Periksa isi $_POST
    
    $nama_pembuat = $data["nama"];
    $topik = htmlspecialchars($_POST['topik']);
    $konten = htmlspecialchars($_POST['konten']);
    $foto_pembuat = $data["foto_profil"];
    
    // Menyimpan pertanyaan ke database
    $query = "INSERT INTO pertanyaan (nama_pembuat, topik, konten, foto_pembuat) VALUES ('$nama_pembuat', '$topik', '$konten', '$foto_pembuat')";
    $result = pg_query($con, $query);
    
    if ($result) {
        if($_GET["status"] == "siswa"){
            header("Location: forum_siswa.php");
        }else{
            header("Location: forum_pengajar.php");
        }
    } else {
        echo "Pertanyaan tidak berhasil diupload";
    }
    
}

// Menutup koneksi
pg_close($conn);
?>
