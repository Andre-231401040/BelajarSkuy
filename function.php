<?php 
$host = "localhost";
$user = "postgres";
$password = "28282828";
$dbname = "BelajarSkuy";
$con = pg_connect("host=$host user=$user password=$password dbname=$dbname");
if(!$con){
    die("Koneksi ke Database Gagal.");
}
?>