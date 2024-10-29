<?php 
$host = "ep-damp-waterfall-a13tat59-pooler.ap-southeast-1.aws.neon.tech";
$user = "default";
$port = "5432";
$password = "PfrRKpVY73zU";
$dbname = "verceldb";
$con = pg_connect("host=$host port=$port user=$user password=$password dbname=$dbname");
if(!$con){
    die("Koneksi ke Database Gagal.");
}
?>