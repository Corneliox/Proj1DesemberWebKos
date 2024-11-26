<?php
session_start();
require_once 'resources/views/template.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kamar C - Kost Ertiga</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
         body {
            font-family: Arial, sans-serif;
            background: url('gambar/bg12.jpg') no-repeat center center fixed;
            background-size: cover; /* Latar belakang mencakup seluruh halaman */
            color: white; /* Warna teks putih agar terlihat di atas latar belakang */
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.9); /* Navbar semi-transparan */
        }

        .container {
            margin-top: 20px;
            background-color: rgba(0, 0, 0, 0.7); /* Latar belakang semi-transparan untuk konten */
            padding: 20px;
            border-radius: 10px;
        }

        .hero-image {
            width: 100%;
            height: auto;
            margin-bottom: 20px;
        }

        .btn-custom {
            background-color: #28a745;
            color: white;
        }

        .btn-custom:hover {
            background-color: #218838;
        }

        footer {
            margin-top: 20px;
            padding: 10px 0; /* Tambahkan padding untuk footer */
            background-color: rgba(0, 0, 0, 0.7); /* Background semi-transparan */
            color: white; /* Warna teks putih */
        }

        footer p {
            margin: 0; /* Menghapus margin untuk footer */
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="index.php">Kost Ertiga</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kamarA.php">Kamar A</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kamarA2.php">Kamar A2</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kamarB.php">Kamar B</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kamarC.php">Kamar C</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="kamarD.php">Kamar D</a>
            </li>
<?php
	if (!isset($_SESSION['user_logged_in'])) {
?>
            <li class="nav-item">
                <a class="nav-link" href="daftar.php">Daftar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
<?php
	}else{
?>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
<?php
	}
?>
        </ul>
    </div>
</nav>
<!-- Navbar End -->

<!-- Kamar C -->
<div class="container">
    <h2>Kamar C</h2>
    <img src="gambar/C.jpg" alt="Kamar C" class="hero-image">

    <!-- <h3>Deskripsi Fasilitas</h3>
    <ul>
        <li>Twin Bed</li>
        <li>Kipas Angin</li>
        <li>Selimut</li>
        <li>Handuk</li>
        <li>WiFi</li>
    </ul> -->
	<?php
		include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
		$sql = "SELECT * FROM kamar WHERE tipe_kamar = 'Kamar C'";
		$result = $conn->query($sql);
		$data = $result->fetch_assoc();
	?>
    <p><strong>Harga: Rp <?= number_format($data['harga_per_malam'],2,',','.'); ?>-/kamar/malam</strong></p>

    <a href="pemesanankamar.php" class="btn btn-custom">Klik Pesan</a>
</div>

<!-- Footer -->
<footer class="text-center">
    <p>&copy; 2024 Wisma Purba Danarta. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
