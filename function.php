<?php 
$host = "localhost";
$user = "postgres";
$dbname = "BelajarSkuy";
$con = pg_connect("host=$host user=$user dbname=$dbname");
if(!$con){
    die("Koneksi ke Database Gagal.");
}

?>