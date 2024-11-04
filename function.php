<?php 
$host = "localhost";
$user = "postgres";
$password = "";
$dbname = "BelajarSkuy";
$con = pg_connect("host=$host user=$user password=$password dbname=$dbname");
if(!$con){
    die("Koneksi ke Database Gagal.");
}
?>