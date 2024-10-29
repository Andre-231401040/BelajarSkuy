<?php 
require "../function.php";
session_start();

if(!isset($_SESSION["id_siswa"])){
    header("Location: ../home/login.php");
}

$id_siswa = $_SESSION["id_siswa"];

$id_course = $_GET["id"];
$_SESSION["id_course"] = $id_course;

if(pg_affected_rows(pg_query($con, "SELECT * FROM enroll WHERE id_siswa = $id_siswa AND id_kursus = $id_course")) === 0){
    $query1 = "INSERT INTO enroll(id_siswa, id_kursus) VALUES ($id_siswa, $id_course)";
    $result1 = pg_query($con,$query1);
    if(is_null($data_course["jumlah_siswa"])){
        $query2 = "UPDATE kursus SET jumlah_siswa = 1 WHERE id = $id_course";
        $result2 = pg_query($con,$query2); 
    }else{
        $query2 = "UPDATE kursus SET jumlah_siswa = jumlah_siswa + 1 WHERE id = $id_course";
        $result2 = pg_query($con,$query2); 
    }
}else{
    header("Location: InsideCourse.php");
}

if (!$result1) {
    die("Gagal memasukkan data: " . pg_last_error($con));
} else {
    echo "berhasil menambahkan data";
}

if (!$result2) {
    die("Gagal memasukkan data: " . pg_last_error($con));
} else {
    echo "berhasil menambahkan data";
}

pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <script>
        window.location.href = "InsideCourse.php";
    </script>
</body>
</html>
