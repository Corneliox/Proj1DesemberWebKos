<?php
session_start();

// Check if user is logged in, if not redirect to login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: loginadmin.php');
    exit();
}

// Handle logout
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['logout'])) {
    session_destroy();
    header('Location: loginadmin.php');
    exit();
}

// Ambil data dari session
$admin_id = $_SESSION['admin_id'];

// Lakukan koneksi ke database
include 'koneksi.php';

// Query untuk mendapatkan detail pengguna berdasarkan ID
$sql = "SELECT * FROM admin WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $admin_id);
$stmt->execute();
$admin = $stmt->get_result()->fetch_assoc();

// Jika data pengguna tidak ditemukan, redirect ke halaman login
/* if (!$admin) {
    header('Location: loginadmin.php');
    exit();
} */
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Wisma Purba Danarta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .container {
            margin-top: 20px;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="admin_dashboard.php">Dashboard Admin</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="admin_dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="editkamar.php">Edit Kamar</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="editpemesanan.php">Edit Pemesanan</a>
            </li>
        </ul>
    </div>
</nav>

<!-- Form Pemesanan Kamar -->
<div class="container">
    <div class="container dashboard-container">
    <h2>Selamat Datang, Admin!</h2>

    <button type="submit" name="logout" class="btn btn-danger">Logout</button>
</div>
</div>

<!-- Footer -->
<footer class="text-center">
    <p>&copy; 2024 Wisma Purba Danarta. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript untuk menghitung harga -->
<script>

</script>

</body>
</html>