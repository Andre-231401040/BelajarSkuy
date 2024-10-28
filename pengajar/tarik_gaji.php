<?php 
require "../function.php";
session_start();

$id_pengajar = $_SESSION["id_pengajar"];

if(pg_fetch_assoc(pg_query($con, "SELECT * FROM gaji_ditarik where id_pengajar = $id_pengajar"))){
    $gaji_ditarik = $_POST["pendapatan"];
    $result = pg_query($con, "UPDATE gaji_ditarik SET jumlah = jumlah + $gaji_ditarik WHERE id_pengajar = $id_pengajar");

    if(!$result){
        echo "<script>alert('Gaji gagal ditarik')</script>";
    }else{
        header("Location: home.php");
    }
}else{
    $gaji_ditarik = $_POST["pendapatan"];
    $result = pg_query($con, "INSERT INTO gaji_ditarik (id_pengajar, jumlah) VALUES ($id_pengajar, $gaji_ditarik)");

    if(!$result){
        echo "<script>alert('Gaji gagal ditarik')</script>";
    }else{
        header("Location: home.php");
    }
}

?>