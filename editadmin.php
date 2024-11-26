<?php
	session_start();
	require_once 'config/helper.php';
	require_once 'resources/views/template.php';

	// Cek apakah pengguna sudah login
	if (!isset($_SESSION['admin_logged_in'])) {
		header('Location: login.php');
		exit();
	}

	// Ambil informasi admin yang sedang login dari session
	$admin_id = $_SESSION['admin_id'];

	include 'koneksi.php'; // Pastikan koneksi database di-include

	$error_message = '';
	$success_message = '';

	// Mengambil data admin dari database
	$sql = "SELECT * FROM admin WHERE id = $admin_id";
	$result = $conn->query($sql);
	$admin_data = $result->fetch_assoc();

	// Proses form jika ada request POST
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$new_username = $_POST['username'];
		$current_password = $_POST['current_password'];
		$new_password = $_POST['new_password'];
		$confirm_password = $_POST['confirm_password'];

		// Verifikasi password lama
		if (password_verify($current_password, $admin_data['password'])) {
			// Cek jika admin ingin mengubah username
			if (!empty($new_username)) {
				$sql_update_username = "UPDATE admin SET username = '$new_username' WHERE id = $admin_id";
				$conn->query($sql_update_username);
				$_SESSION['username'] = $new_username; // Update session username
				$success_message .= 'Username berhasil diubah. ';
			}

			// Cek jika admin ingin mengubah password
			if (!empty($new_password) && ($new_password === $confirm_password)) {
				$hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
				$sql_update_password = "UPDATE admin SET password = '$hashed_password' WHERE id = $admin_id";
				$conn->query($sql_update_password);
				$success_message .= 'Password berhasil diubah.';
			} else if ($new_password !== $confirm_password) {
				$error_message .= 'Password baru dan konfirmasi tidak cocok. ';
			}
		} else {
			$error_message .= 'Password lama salah. ';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta content="width=device-width, initial-scale=1.0" name="viewport">
	<title>Edit Admin - <?= $application_name; ?></title>
	<meta name="description" content="<?= $description; ?>">
	<meta name="keywords" content="<?= $keywords; ?>">

	<?= layout('css'); ?>
</head>
<body class="starter-page-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="./dashboard.php" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo11.png" alt="">
        <h1 class="sitename">Dashboard Admin</h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="./dashboard.php" class="active">Dashboard</a></li>
		  <li><a href="./kamar.php" class="active">Kamar</a></li>
		  <li><a href="./transaksi.php" class="active">Transaksi</a></li>
		  <li><a href="./pelanggan.php" class="active">Pengguna</a></li>
		  <li><a href="./editadmin.php" class="active">Edit Admin</a></li>
		  <li><a href="./list.php" class="active">list</a></li> 
		  <li><a class="text-danger" href="javascript:void(0)"><?= $_SESSION['username']; ?></a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted flex-md-shrink-0" href="./logoutadmin.php">Logout</a>

    </div>
  </header>

	<main class="main">
		<!-- Page Title -->
		<div class="page-title">
			<nav class="breadcrumbs">
				<div class="container">
					<ol>
						<li><a href="./dashboard.php">Dashboard</a></li>
						<li class="current">Edit Admin</li>
					</ol>
				</div>
			</nav>
		</div><!-- End Page Title -->

		<section id="starter-section" class="starter-section section">
			<div class="container col-6">
				<?php if ($error_message): ?>
					<div class="alert alert-danger"><?= $error_message; ?></div>
				<?php endif; ?>

				<?php if ($success_message): ?>
					<div class="alert alert-success"><?= $success_message; ?></div>
				<?php endif; ?>

				<form action="" method="post">
					<h4>Edit Admin</h4>

					<div class="form-group">
						<label for="username">Username Baru</label>
						<input type="text" name="username" id="username" class="form-control" placeholder="Username baru" value="<?= $admin_data['username']; ?>">
					</div>

					<div class="form-group">
						<label for="current_password">Password Lama</label>
						<input type="password" name="current_password" id="current_password" class="form-control" placeholder="Masukkan password lama" required>
					</div>

					<div class="form-group">
						<label for="new_password">Password Baru</label>
						<input type="password" name="new_password" id="new_password" class="form-control" placeholder="Masukkan password baru">
					</div>

					<div class="form-group">
						<label for="confirm_password">Konfirmasi Password Baru</label>
						<input type="password" name="confirm_password" id="confirm_password" class="form-control" placeholder="Konfirmasi password baru">
					</div>

					<div class="text-center">
						<button type="submit" class="btn btn-primary">Simpan Perubahan</button>
					</div>
				</form>
			</div>
		</section><!-- /Starter Section Section -->

	</main>

	<?= layout('footer'); ?>

	<a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

	<?= layout('js'); ?>
</body>
</html>
