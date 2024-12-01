<?php
session_start();

// Cek apakah pengguna sudah login
if (isset($_SESSION['admin_logged_in'])) {
    header('Location:admin_dashboard.php');
    exit();
}
include 'koneksi.php'; // Pastikan Anda memiliki koneksi database

$login_success = false;
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Cek username dan password di database
    $sql = "SELECT * FROM admin WHERE username = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param('s', $username);
	$stmt->execute();
	$result = $stmt->get_result();
	
	if($result->num_rows > 0){
		$data = $result->fetch_assoc();

		if(password_verify($password, $data['password'])){
			$_SESSION['admin_logged_in'] = true;
			$_SESSION['admin_id'] = $admin['id'];
			$login_success = true;
			header('Location: admin_dashboard.php'); // Redirect ke dashboard admin setelah login berhasil
			exit();
		}else{
			$error_message = 'Username atau password salah.';
		}
	}else{
		$error_message = 'Username atau password salah.';
	}
	
	
	
	/* $sql = "SELECT * FROM admin WHERE username = :username";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    
    // Ambil data admin
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // Jika admin ditemukan dan password cocok
    if ($admin && password_verify($password, $admin['password'])) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_id'] = $admin['id'];
        $login_success = true;
        header('Location: admin_dashboard.php'); // Redirect ke dashboard admin setelah login berhasil
        exit();
    } else {
        $error_message = 'Username atau password salah.';
    } */
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Wisma Purba Danarta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
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

<div class="container login-container">
    <h2>Login Admin</h2>
    <?php if ($error_message): ?>
        <div class="alert alert-danger">
            <?php echo $error_message; ?>
        </div>
    <?php endif; ?>
    <form method="POST" action="">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-custom btn-block">Login</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>