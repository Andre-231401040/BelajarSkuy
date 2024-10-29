<?php 
$host = $_ENV["PG_HOST"];
$user = $_ENV["PG_USER"];
$password = $_ENV["PG_PASSWORD"];
$dbname = $_ENV["PG_DB"];
$con = pg_connect("host=$host user=$user password=$password dbname=$dbname");
if(!$con){
    die("Koneksi ke Database Gagal.");
}

?>