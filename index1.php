<?php
session_start();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kost Ertiga Ngaliyan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    
    <!-- Google Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap">
    
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .navbar {
            background-color: #ADD8E6;
            margin-bottom: 20px;
        }
        .navbar-nav .nav-link {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
            font-size: 18px;
        }
        
        .hero-image {
            width: 100%;
            height: auto; 
            max-width: 800px; 
            object-fit: cover; 
            border-radius: 10px; 
            margin-bottom: 20px; 
        }
        .gambar-wisma {
            text-align: center; 
            padding: 20px 0;
            background-color: #f2f2f2; 
        }
        .container, .tentang, .peta, .informasi {
            background: #D3D3D3; 
            padding: 20px;
            border-radius: 10px;
            text-align: center; 
            margin: 20px auto; 
            max-width: 800px; 
        }
        iframe {
            width: 100%;
            height: 450px;
            border: 0;
        }
        footer {
            margin-top: 20px;
            padding: 20px 0;
            text-align: center;
            background-color: #ADD8E6;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light">
    <a class="navbar-brand" href="#">Kost Ertiga Ngaliyan</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="kamarekonomi.php">Kamar Ekonomi</a></li>
            <li class="nav-item"><a class="nav-link" href="kamarstandart.php">Kamar Standart</a></li>
            <li class="nav-item"><a class="nav-link" href="kamardeluxe.php">Kamar Deluxe</a></li>
<?php
	if (!isset($_SESSION['user_logged_in'])) {
?>
            <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
            <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
<?php
	}else{
?>
            <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
<?php
	}
?>
            <li class="nav-item"><a class="nav-link" href="user.php">User</a></li>
        </ul>
    </div>
</nav>

<div class="gambar-wisma">
<img src="gambar/wismapb.jpg" alt="Kost Ertiga Ngaliyan" class="hero-image">
</div>

<div class="tentang container">
    <h2>Selamat datang di Kost Ertiga Ngaliyan</h2>
    <p>Kost Ertiga Ngaliyan terletak di jantung kota Semarang. Dengan lingkungan yang asri dan lokasi yang sangat strategis, menjadikan Kost Ertiga Ngaliyan sebagai destinasi penginapan yang tepat untuk menemani liburan anda di kota Semarang. Pesan Kamar Sekarang Juga.</p>
</div>

<div class="peta container">
    <h3>Alamat Kost Ertiga Ngaliyan</h3>
    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1983.4828088531916!2d110.4055123!3d-7.0037744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b731ad39417%3A0x8bdf4c3ec416195f!2sJl.%20Veteran%20No.7%2C%20Lempongsari%2C%20Kec.%20Gajahmungkur%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050231!5e0!3m2!1sid!2sid!4v1695387606674"></iframe>
</div>

<div class="informasi container">
    <h3>Informasi Cek In dan Cek Out</h3>
    <p>Jam Cek In: 14:00 WIB</p>
    <p>Jam Cek Out: 12:00 WIB</p>

    <h3>Ikuti Kami di Instagram</h3>
    <p>Instagram: <a href="https://www.instagram.com/yayasanpurbadanarta" target="_blank">@yayasanpurbadanarta</a></p>
</div>

<footer>
    <p>&copy; 2024 Kost Ertiga Ngaliyan. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html> 