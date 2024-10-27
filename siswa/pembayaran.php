<?php
require "../function.php";
session_start();

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$email = $data_siswa["email"];

$id = $_SESSION["id"];
$query = "INSERT INTO success_payment(id, id_siswa, nama, email) VALUES ($id, $id_siswa, '$nama', '$email')";
$result = pg_query($con, $query);
if (!$result) {
    die("Gagal memasukkan data: " . pg_last_error($con));
} else {
    echo "berhasil memasukkan data";
}
pg_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
</head>
<body>
    <script>
        window.location.href = "course.php";
    </script>
</body>
</html>