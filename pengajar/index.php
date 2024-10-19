<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tugas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5dc; /* Warna latar belakang seperti di gambar */
        }
        .container {
            padding: 20px;
        }
        .header {
            display: flex;
            align-items: center;
            background-color: #e0f7fa;
            border-radius: 20px;
            padding: 10px;
            margin-bottom: 20px;
        }
        .header img {
            border-radius: 50%;
            width: 50px;
            height: 50px;
        }
        .header h2 {
            margin-left: 10px;
        }
        .navbar {
            display: flex;
            justify-content: space-around;
            margin-bottom: 20px;
        }
        .navbar a {
            text-decoration: none;
            color: black;
            padding: 10px;
            border-radius: 10px;
        }
        .navbar a.active {
            background-color: #e0f7fa;
        }
        .table {
            width: 100%;
            border-spacing: 10px;
        }
        .table td {
            background-color: #00e5ff;
            padding: 20px;
            border-radius: 20px;
            text-align: center;
        }
        .action-buttons {
            margin-top: 20px;
            text-align: center;
        }
        .action-buttons button {
            padding: 10px 20px;
            margin: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header with image and text -->
        <div class="header">
            <img src="profile.jpg" alt="Profile">
            <h2>Nama Pengajar</h2>
        </div>

        <!-- Navigation bar -->
        <div class="navbar">
            <a href="#">Home</a>
            <a href="#">Course</a>
            <a href="#">Forum</a>
            <a href="#">Quiz</a>
            <a href="#" class="active">Assignment</a>
        </div>

        <!-- Table for assignments -->
        <table class="table">
            <tr>
                <td>Batas Waktu</td>
                <td>Kursus</td>
            </tr>
            <tr>
                <td>10 Oktober 2024</td>
                <td>Struktur Data</td>
            </tr>
            <tr>
                <td>15 Oktober 2024</td>
                <td>Algoritma</td>
            </tr>
            <!-- Add more rows as needed -->
        </table>

        <!-- Action buttons -->
        <div class="action-buttons">
            <button>Tambah Tugas</button>
            <button>Hapus Tugas</button>
        </div>
    </div>
</body>
</html>
