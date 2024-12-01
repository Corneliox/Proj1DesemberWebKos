<?php
session_start();
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Ambil data dari session
$user_id = $_SESSION['user_id'];

// Lakukan koneksi ke database
include 'koneksi.php';

// Query untuk mendapatkan detail pengguna berdasarkan ID
$sql = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Jika data pengguna tidak ditemukan, redirect ke halaman login
if (!$user) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard User - Wisma Purba Danarta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .dashboard-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
        .dashboard-container h2 {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<div class="container dashboard-container">
    <h2>Selamat Datang, <?= htmlspecialchars($user['nama']) ?>!</h2>
    
    <div class="mb-3">
        <strong>Nama:</strong> <?= htmlspecialchars($user['nama']) ?>
    </div>
    
    <div class="mb-3">
        <strong>Email:</strong> <?= htmlspecialchars($user['email']) ?>
    </div>
    
    <div class="mb-3">
        <strong>No HP:</strong> <?= htmlspecialchars($user['no_hp']) ?>
    </div>

    <a href="index.php" class="btn btn-secondary btn-block mt-2">Back to Home</a> <!-- Tombol Back to Home -->
    <a href="logout.php" class="btn btn-danger btn-block mt-2">Logout</a>
</div>


<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>