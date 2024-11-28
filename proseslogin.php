<?php
session_start();

// Konfigurasi database
$host = 'localhost'; // Alamat host
$dbname = 'mesy7597_purbadanarta'; // Nama database
$username = 'mesy7597_purbadanarta2024'; // Username database
$password = 'arya2024'; // Password database

try {
    // Membuat koneksi dengan PDO
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Mengatur mode error PDO menjadi Exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Koneksi gagal: " . $e->getMessage());
}

$login_success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Cek email di database
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bindParam(':email', $email);
        
        // Eksekusi statement
        $stmt->execute();

        // Ambil data pengguna
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Jika pengguna ditemukan dan password cocok
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
			$_SESSION['user_name'] = $user['nama'];
            $login_success = true; // Set menjadi true saat login berhasil
            header('Location: index.php');
            exit; // Hentikan script setelah redirect
        } else {
            // Jika pengguna tidak ditemukan atau password tidak cocok
            $error_message = 'Email atau password salah.';
            header('Location: login.php?error=' . urlencode($error_message));
            exit; // Hentikan script setelah redirect
        }
    } else {
        $error_message = 'Terjadi kesalahan dalam mempersiapkan statement.';
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proses Login - Kost Ertiga Ngaliyan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .login-result-container {
            max-width: 500px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        .btn-custom {
            background-color: #007bff;
            color: white;
        }
        .btn-custom:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

<div class="container login-result-container">
    <?php if ($login_success): ?>
        <h2>Login Berhasil!</h2>
        <p>Selamat datang kembali di <strong>Kost Ertiga Ngaliyan</strong>.</p>
        <p>Anda telah berhasil login. Silahkan <a href="index.php">mulai reservasi</a> kamar Anda.</p>
        <a href="index.php" class="btn btn-custom btn-block mt-3">Mulai Reservasi</a>
    <?php else: ?>
        <h2>Login Gagal</h2>
        <?php if ($error_message): ?>
            <p><?php echo htmlspecialchars($error_message); ?></p>
        <?php else: ?>
            <p>Email atau password salah. Silahkan coba lagi.</p>
        <?php endif; ?>
        <a href="login.php" class="btn btn-custom btn-block mt-3">Kembali ke Login</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
