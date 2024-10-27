<?php
require "../function.php";
session_start();

if (!isset($_SESSION['id_siswa'])) {
    header("Location: login.php");
    exit;
}

$id_siswa = $_SESSION['id_siswa'];
$id_kursus = $_GET['id'];

$check_enrollment = pg_query($con, "SELECT * FROM enrollment WHERE id_siswa = $id_siswa AND id_kursus = $id_kursus");
if (pg_num_rows($check_enrollment) > 0) {
    header("Location: InsideCourse.php?id=$id_kursus&already_enrolled=true");
    exit;
}

$enroll_query = pg_query($con, "INSERT INTO enrollment (id_siswa, id_kursus, enrollment_date) VALUES ($id_siswa, $id_kursus, CURRENT_DATE)");


if ($enroll_query) {
    header("Location: InsideCourse.php?id=$id_kursus");
} else {
    echo "Enrollment failed: " . pg_last_error($con);
}

pg_close($con);
?>