<?php 
require "./function.php";
session_start();

if(!isset($_SESSION["isFound"])){
    header("Location: home/login.php");
}

$id_postingan = $_GET["id"];
$email_penyimpan = $_GET["email_penyimpan"];
$jalur = $_GET["jalur"];
$jalur .= ".php";

$query = "INSERT INTO posting_disimpan (id_postingan, email_penyimpan) VALUES ($id_postingan, '$email_penyimpan')";

$result = pg_query($con, $query);

if(!$result){
    echo "<script>alert('Postingan gagal disimpan')</script>";
}else{
    if($_SESSION["isFound"] === "student"){
        header("Location: $jalur");
    }else if($_SESSION["isFound"] === "teacher"){
        header("Location: $jalur");
    }else{
        header("Location: home/login.php");
    }
}

?>