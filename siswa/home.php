<?php 
require "../function.php";
session_start();

$id_siswa = $_SESSION["id_siswa"];
$data_siswa = pg_fetch_assoc(pg_query($con, "SELECT * FROM siswa WHERE id = $id_siswa"));
$nama = $data_siswa["nama"];
$gambar = $data_siswa["foto_profil"];


$data_enrolled_courses = pg_query($con, "SELECT kursus.judul, kursus.harga, enrollment.enrollment_date 
    FROM kursus INNER JOIN enrollment ON kursus.id = enrollment.id_kursus 
    WHERE enrollment.id_siswa = $id_siswa
    ORDER BY enrollment.enrollment_date DESC");
$courses = pg_fetch_all($data_enrolled_courses);

$data_latest_courses = pg_query($con, "SELECT judul, harga FROM kursus LIMIT 6");
$latest_courses = pg_fetch_all($data_latest_courses);


pg_close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $nama; ?> | Home</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <link rel="stylesheet" href="styles/homeStyle.css">

    <!-- Fonts -->
    <!-- Racing Sans One -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Racing+Sans+One&display=swap" rel="stylesheet" />
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />

</head>
<body>
    <header>
        <nav>
            <a href="./profil_siswa.php" class="profil">
                <?php if($gambar != null){ ?>
                    <img src="../images/foto_profil/<?= $gambar; ?>" alt="foto profil <?= $nama; ?>">
                <?php }else{ ?>
                    <img src="../images/foto_profil/foto-1.jpg" alt="foto profil default">
                <?php } ?>
                <div class="nama">
                    <h2><?= $nama; ?></h2>
                    <div class="underline"></div>
                </div>
            </a>
            <ul>
                <li>
                    <a href="./home.php">Home</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="./course.php">Course</a>
                    <div class="underline"></div>
                </li>
                <li>
                    <a href="../forum.php">Forum</a>
                    <div class="underline"></div>
                </li>
            </ul>
        </nav>
    </header>

    <h1 style="margin-left: 30px;">Hi, <?= $nama; ?> </h1>


    <div id="activities">
    <div class="rectangle-2">
        <div class="circle-2">
            <p class="title">Course</p>
        </div>
        <div class="square-container">
            <div class="square-6">
                <p class="text">Date</p>
            </div>
            <div class="square-5">
                <p class="text">Title</p>
            </div>

            <?php
            $min_courses = 6; 
            $total_courses = count($courses);
            $course_count = max($total_courses, $min_courses); 

            
            for ($i = 0; $i < $course_count; $i++): 
                if ($i < $total_courses): 
            ?>
                    <div class="square-6">
                        <p class="text"><?= $courses[$i]['enrollment_date']; ?></p>
                    </div>
                    <div class="square-5">
                        <p class="text"><?= $courses[$i]['judul']; ?></p>
                    </div>
                <?php else: ?>
                    <div class="square-6"></div>
                    <div class="square-5"></div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>
    </div>
</div>
    
    <div id="activities">
    <div class="rectangle-2">
        <div class="circle-2">
            <p class="title">Latest Courses</p>
        </div>
        <div class="square-container">
            <div class="square-6">
                <p class="text">Price</p>
            </div>
            <div class="square-5">
                <p class="text">Title</p>
            </div>

            <?php if ($latest_courses): ?>
                <?php 
                
                $max_courses = 6; 
                $course_count = 0;

                foreach ($latest_courses as $course): 
                    if ($course_count >= $max_courses) break; 
                    ?>
                    <div class="square-6">
                        <p class="text"><?= ($course['harga']); ?></p>
                    </div>
                    <div class="square-5">
                        <p class="text" ><?= ($course['judul']); ?></p>
                    </div>
                    <?php 
                    $course_count++;
                endforeach; 
            else: ?>
                <div class="square-6">
                    <p class="text">Tidak Ada Kursus Baru</p>
                </div>
                <div class="square-5"></div>
            <?php endif; ?>

            <?php 
            
            $empty_squares = $max_courses - $course_count;
            for ($i = 0; $i < $empty_squares; $i++): ?>
                <div class="square-6"></div>
                <div class="square-5"></div>
            <?php endfor; ?>
        </div>
    </div>
</div>

   
</body>
</html>