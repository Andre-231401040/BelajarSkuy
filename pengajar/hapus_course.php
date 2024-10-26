<?php 
require "../function.php";

$id_kursus = $_GET["id_kursus"];

$query = "DELETE FROM kursus WHERE id = $id_kursus";

$result = pg_query($con, $query);

if(!$result){
    echo "<script>alert('Kursus gagal dihapus')</script>";
    header("refresh: 0; course.php");
}else{
    echo "<script>alert('Kursus berhasil dihapus')</script>";
    header("refresh: 0; course.php");
}

?>