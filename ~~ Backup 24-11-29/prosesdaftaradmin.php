<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Koneksi ke database
$host = 'localhost';
$username = 'mesy7597_purbadanarta2024';
$password_db = 'arya2024'; // Rename to avoid conflict with form password
$database = 'mesy7597_purbadanarta';

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password_db, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil data dari form
$username = isset($_POST['username']) ? $_POST['username'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';

// Hash password untuk keamanan
$password_hashed = password_hash($password, PASSWORD_DEFAULT);

// Inisialisasi variabel status
$success = false;
$error_message = '';

// Gunakan prepared statement untuk keamanan
$stmt = $conn->prepare("INSERT INTO admin (username, password) VALUES ( ?, ?)");
$stmt->bind_param("ss", $username, $password_hashed);

if ($stmt->execute()) {
    $success = true;
} else {
    $error_message = "Terjadi kesalahan: " . $stmt->error;
}

// Tutup koneksi
$stmt->close();
mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Daftar - Wisma Purba Danarta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .register-result-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            text-align: center;
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

<div class="container register-result-container">
    <?php if ($success): ?>
        <h2>Pendaftaran Berhasil!</h2>
        <p>Selamat, akun Anda telah berhasil didaftarkan di <strong>Wisma Purba Danarta</strong>.</p>
        <p>Silahkan <a href="login.php">login</a> untuk melakukan reservasi kamar.</p>
        <a href="loginadmin.php" class="btn btn-custom btn-block mt-3">Login Sekarang</a>
    <?php else: ?>
        <h2>Pendaftaran Gagal</h2>
        <?php if (!empty($error_message)): ?>
            <p><?php echo $error_message; ?></p>
        <?php else: ?>
            <p>Terjadi kesalahan saat mendaftar. Silahkan coba lagi.</p>
        <?php endif; ?>
        <a href="daftaradmin.php" class="btn btn-custom btn-block mt-3">Kembali ke Form Daftar</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
