<?php 
$host = $_ENV["PG_HOST"];
$user = $_ENV["PG_USER"];
$port = $_ENV["PG_PORT"];
$password = $_ENV["PG_PASSWORD"];
$dbname = $_ENV["PG_DB"];
$con = pg_connect("host=$host port=$port user=$user password=$password dbname=$dbname");
if(!$con){
    die("Koneksi ke Database Gagal.");
}
?>