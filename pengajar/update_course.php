<?php 
require "../function.php";

$id_kursus = $_GET["id_kursus"];
    
if(isset($_POST["submit"])){
    $judul = $_POST["judul"];
    $deskripsi = $_POST["deskripsi"];
    $kategori = $_POST["kategori"];
    $harga = $_POST["harga"];
    $tugas = $_POST["tugas"];
    $kuis = $_POST["kuis"];
    $nama_file_pdf = $_FILES["materi_pdf"]["name"];
    $tmp_pdf = $_FILES["materi_pdf"]["tmp_name"];
    $nama_file_thumbnail = $_FILES["thumbnail"]["name"];
    $tmp_thumbnail = $_FILES["thumbnail"]["tmp_name"];
    $ekstensi_valid_pdf = ["pdf"];
    $ekstensi_valid_thumbnail = ["jpg", "png", "jpeg"];

    if($_FILES["materi_video"]["size"] !== 0){
        $nama_file_video = $_FILES["materi_video"]["name"];
        $tmp_video = $_FILES["materi_video"]["tmp_name"];
        $ekstensi_valid_video = ["mp4"];

        $ekstensi_pdf = explode(".", $nama_file_pdf);
        $ekstensi_pdf = strtolower(end($ekstensi_pdf));
        $ekstensi_video = explode(".", $nama_file_video);
        $ekstensi_video = strtolower(end($ekstensi_video));
        $ekstensi_thumbnail = explode(".", $nama_file_thumbnail);
        $ekstensi_thumbnail = strtolower(end($ekstensi_thumbnail));

        if(!in_array($ekstensi_pdf, $ekstensi_valid_pdf) || !in_array($ekstensi_video, $ekstensi_valid_video) || !in_array($ekstensi_thumbnail, $ekstensi_valid_thumbnail)){
            echo "<script>alert('Format file ada yang tidak sesuai')</script>";
        }else{
            $materi_pdf = uniqid();
            $materi_pdf .= "." . $ekstensi_pdf;
            $materi_video = uniqid();
            $materi_video .= "." . $ekstensi_video;
            $thumbnail = uniqid();
            $thumbnail .= "." . $ekstensi_thumbnail;
            move_uploaded_file($tmp_pdf, "../materi/pdf/" . $materi_pdf);
            move_uploaded_file($tmp_video, "../materi/video/" . $materi_video);
            move_uploaded_file($tmp_thumbnail, "../thumbnail/" . $thumbnail);

            $query = "UPDATE kursus 
            SET judul = '$judul', deskripsi = '$deskripsi', kategori = '$kategori', harga = $harga, materi_pdf = '$materi_pdf', materi_video = '$materi_video', tugas = '$tugas', kuis = '$kuis', thumbnail = '$thumbnail' 
            WHERE id = $id_kursus";
            $result = pg_query($con, $query);

            if(!$result){
                echo "<script>alert('Kursus gagal diperbarui')</script>";
            }else{
                echo "<script>alert('Kursus berhasil diperbarui')</script>";
                header("refresh: 0; course.php");
            }
        }
    }else{
        $ekstensi_pdf = explode(".", $nama_file_pdf);
        $ekstensi_pdf = strtolower(end($ekstensi_pdf));
        $ekstensi_thumbnail = explode(".", $nama_file_thumbnail);
        $ekstensi_thumbnail = strtolower(end($ekstensi_thumbnail));

        if(!in_array($ekstensi_pdf, $ekstensi_valid_pdf) || !in_array($ekstensi_thumbnail, $ekstensi_valid_thumbnail)){
            echo "<script>alert('Format file ada yang tidak sesuai')</script>";
        }else{
            $materi_pdf = uniqid();
            $materi_pdf .= "." . $ekstensi_pdf;
            $thumbnail = uniqid();
            $thumbnail .= "." . $ekstensi_thumbnail;
            move_uploaded_file($tmp_pdf, "../materi/pdf/" . $materi_pdf);
            move_uploaded_file($tmp_thumbnail, "../thumbnail/" . $thumbnail);

            $query = "UPDATE kursus 
            SET judul = '$judul', deskripsi = '$deskripsi', kategori = '$kategori', harga = $harga, materi_pdf = '$materi_pdf', materi_video = '$materi_video', tugas = '$tugas', kuis = '$kuis', thumbnail = '$thumbnail' 
            WHERE id = $id_kursus";
            $result = pg_query($con, $query);

            if(!$result){
                echo "<script>alert('Kursus gagal diperbarui')</script>";
            }else{
                echo "<script>alert('Kursus berhasil diperbarui')</script>";
                header("refresh: 0; course.php");
            }
        }
    }
}

?>