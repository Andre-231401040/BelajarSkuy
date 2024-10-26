<?php 
$host = "localhost";
$user = "postgres";
$dbname = "BelajarSkuy";
$password = "";
$con = pg_connect("host=$host user=$user password=$password dbname=$dbname");

if(!$con){
    die("Koneksi ke Database Gagal.");
}
?>