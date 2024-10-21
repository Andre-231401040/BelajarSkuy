<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>John Doe | Profil</title>
    <link rel="icon" href="../images/logo.png" sizes="32x32" type="image/png" />
    <!-- Fonts -->
    <!-- Quicksand -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@300..700&display=swap" rel="stylesheet" />
    <!-- Style -->
    <link rel="stylesheet" href="profil_siswa.css">
    
</head>
<body>
    <main>
        <form action="./edit_profil.php" method="post" enctype="multipart/form-data">
            <img src="../images/pengajar/foto_profil/foto-1.jpg" alt="foto profil default">
            <label for="nama">Nama
                <input type="text" id="nama" name="nama" value="John Doe" required>
            </label>
            <label for="tanggal_lahir">Tanggal Lahir
                <input type="date" id="tanggal_lahir" name="tanggal_lahir" value="1990-01-01" required>
            </label>
            <label for="pendidikan_terakhir">Pendidikan Ditempuh
            <input type="text" id="pendidikan_terakhir" name="pendidikan_terakhir" list="pendidikan-options" placeholder="Pilih pendidikan" required>
            </label>
            <datalist id="pendidikan-options">
                <option value="SD">
                <option value="SMP">
                <option value="SMA">
                <option value="D-3 / S-1">
                <option value="Tidak Bersekolah">
            </datalist>
            <label for="sekolah">Asal Sekolah
                <input type="text" id="sekolah" name="sekolah" value="Universitas Sumatera Utara">
            </label>
            <label for="email">Email
                <input type="text" id="email" name="email" required value="johndoe@example.com">
            </label>
            <label for="nomor_handphone">No Handphone
                <input type="text" id="nomor_handphone" name="nomor_handphone" value="08123456789">
            </label>
            <label for="bidang_keahlian">Bidang Diminati
                <input type="text" id="bidang_keahlian" name="bidang_keahlian" value="Web Development">
            </label>
            <label for="password">Kata Sandi
                <input type="password" id="password" name="password" value="password123" required>
            </label>
            <label for="confirmation_password">Konfirmasi Kata Sandi
                <input type="password" id="confirmation_password" name="confirmation_password" value="password123" required>
            </label>
            <label for="deskripsi_diri">Deskripsi Diri
                <textarea id="deskripsi_diri" name="deskripsi_diri">saya tertarik dalam bidang teknologi</textarea>
            </label>
            <label for="foto-profil">
                Foto Profil
                <input type="file" id="foto-profil" name="foto-profil">
            </label>
            <button type="submit" name="submit">Simpan</button>
        </form>
    </main>
</body>
</html>
