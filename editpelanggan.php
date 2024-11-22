<?php
	session_start();

	//require_once 'config/connection.php';
	require_once 'config/helper.php';
	require_once 'resources/views/template.php';

	// session('all');
	// Cek apakah pengguna sudah login
	if (!isset($_SESSION['admin_logged_in'])) {
		header('Location:loginadmin.php');
		exit();
	}
	list($application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube) = settings();

	include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$sql = "SELECT * FROM users WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$result = $stmt->get_result();

		if($result->num_rows > 0){
			$data = $result->fetch_assoc();
		}else{
			$_SESSION['warning'] = '<strong>Peringatan!</strong> Data Pengguna Tidak Ditemukan.';
			header('location: pelanggan.php');
			exit();
		}
		$stmt->close();
		// $conn->close();
	}else{
		$_SESSION['warning'] = '<strong>Peringatan!</strong> Pilih Data yang Ingin Diedit.';
		header('location: pelanggan.php');
		exit();
	}
	
	if(isset($_POST['submit'])){
		$nama = $_POST['nama'];
		$email = $_POST['email'];
		$no_hp = $_POST['no_hp'];
		//$password = $_POST['password'];

		$sql = "UPDATE users SET nama = ?, email = ?, no_hp = ? WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('sssi', $nama, $email, $no_hp, $id);
		$stmt->execute();
		$update = $stmt->affected_rows;

		if($stmt->errno){
			$_SESSION['error'] = '<strong>Error!</strong> Data Pengguna Gagal Diedit.';
			header('location: pelanggan.php');
			exit();
		}

		if($update > 0){
			$_SESSION['success'] = '<strong>Sukses!</strong> Data Pengguna Berhasil Diedit.';
			header('location: pelanggan.php');
		}else{
			$_SESSION['error'] = '<strong>Error!</strong> Data Pengguna Gagal Diedit.';
			header('location: pelanggan.php');
		}
		$stmt->close();
		$conn->close();
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Edit Pengguna - <?= $application_name; ?></title>
  <meta name="description" content="<?= $description; ?>">
  <meta name="keywords" content="<?= $keywords; ?>">

  <?= layout('css'); ?>
  <style>
  </style>
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
			<li><a href="./kamar.php">Pengguna</a></li>
            <li class="current">Edit Pengguna</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Comment Form Section -->
	  <section id="comment-form" class="comment-form section">
		<div class="container col-4">

		  <form action=""  method="post">

			<h4>Edit Pengguna</h4>
			<p>Edit Data Pengguna</p>
			<div class="row">
			  <div class="col form-group">
				<input id="nama" name="nama" type="text" class="form-control" placeholder="Nama Pengguna" value="<?= $data['nama']; ?>" required>
			  </div>
			</div>
			<div class="row">
			  <div class="col form-group">
				<input id="email" name="email" type="email" class="form-control" placeholder="Email" value="<?= $data['email']; ?>" required>
			  </div>
			</div>
			<div class="row">
			  <div class="col form-group">
				<input id="no_hp" name="no_hp" type="text" class="form-control" placeholder="Telepon" value="<?= $data['no_hp']; ?>" required>
			  </div>
			</div>
			<!--<div class="row">
			  <div class="col form-group">
				<input id="password" name="password" type="password" class="form-control" placeholder="password" value="<?= $data['password']; ?>" required>
			  </div>
			</div>-->

			<div class="text-center">
			  <button type="submit" name="submit" value="submit" class="btn btn-primary">Simpan</button>
			  <button type="button" onclick="window.history.back()" class="btn btn-danger" style="border-radius: 4px; padding: 10px 20px; border: 0;">Kembali</button>
			</div>

		  </form>

		</div>
	  </section><!-- /Comment Form Section -->

  </main>

  <?= layout('footer'); ?><!-- End Footer -->

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?= layout('js'); ?>

  <script type="text/javascript">
  $(document).ready(function(){
	$('#myTable').DataTable({
		responsive: true
	});
  });
  </script>

</body>

</html>