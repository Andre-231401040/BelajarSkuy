<?php 
$host = $_ENV["POSTGRES_HOST"];
$user = $_ENV["POSTGRES_USER"];
$password = $_ENV["POSTGRES_PASSWORD"];
$dbname = $_ENV["POSTGRES_DATABASE"];
$con = pg_connect("host=$host user=$user password=$password dbname=$dbname");
if(!$con){
    die("Koneksi ke Database Gagal.");
}
?>