<?php
	session_start();

	//require_once 'config/connection.php';
	require_once 'config/helper.php';
	require_once 'resources/views/template.php';

	//session('login');
	// Cek apakah pengguna sudah login
	if (isset($_SESSION['admin_logged_in'])) {
		header('Location: dashboard.php');
		exit();
	}
	list($application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube) = settings();
	
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
				$_SESSION['admin_id'] = $data['id'];
				$_SESSION['username'] = $data['username'];
				$login_success = true;
				header('Location: dashboard.php'); // Redirect ke dashboard admin setelah login berhasil
				exit();
			}else{
				$error_message = 'Username atau password salah.';
			}
		}else{
			$error_message = 'Username atau password salah.';
		}
	}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Login Admin - <?= $application_name; ?></title>
  <meta name="description" content="<?= $description; ?>">
  <meta name="keywords" content="<?= $keywords; ?>">

  <?= layout('css'); ?>
  <style>
  /* Menyesuaikan tampilan di layar kecil */
  @media (max-width: 576px) {
    .container.col-4 {
      width: 100%;
      padding: 0 20px;
    }

    .page-title {
      text-align: center;
    }

    .sitename {
      font-size: 24px; /* Perkecil ukuran teks di ponsel */
    }

    /* Adjust button size for smaller screens */
    .btn {
      width: 100%;
      padding: 12px;
      font-size: 16px;
    }

    /* Navbar customization for mobile */
    .navmenu ul {
      flex-direction: column;
      align-items: center;
    }

    .navmenu li {
      margin-bottom: 10px;
    }

    .btn-getstarted {
      width: 100%;
      text-align: center;
    }

    /* Mengurangi ukuran padding header pada ponsel */
    header.header {
      padding: 10px 0;
    }

    /* Memastikan form login beradaptasi dengan baik di layar kecil */
    .comment-form {
      padding: 0;
    }

    input[type="text"], input[type="password"] {
      width: 100%;
      padding: 10px;
    }

    /* Title section customization */
    h4 {
      font-size: 20px;
    }

    p {
      font-size: 14px;
    }
  }
</style>

</head>

<body class="starter-page-page">

  <header id="header" class="header d-flex align-items-center sticky-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="./" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo1.png" alt="">
        <h1 class="sitename"><?= $application_name; ?></h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="./" class="active">Beranda</a></li>
          <li class="dropdown"><a href="#"><span>Penginapan</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="./kamarekonomi.php">Kamar Ekonomi</a></li>
			  <li><a href="./kamarstandart.php">Kamar Standart</a></li>
              <li><a href="./kamardeluxe.php">Kamar Deluxe</a></li>
            </ul>
          </li>
          <!--<li><a href="./">Register</a></li>-->
		  <li><a class="text-danger" href="javascript:void(0)">Admin</a></li>
        </ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>

      <a class="btn-getstarted flex-md-shrink-0" href="./daftaradmin.php">Daftar</a>

    </div>
  </header>

  <main class="main">

    <!-- Page Title -->
    <div class="page-title">
      <nav class="breadcrumbs">
        <div class="container">
          <ol>
            <li><a href="./">Beranda</a></li>
            <li class="current">Login Admin</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Comment Form Section -->
	  <section id="comment-form" class="comment-form section">
		<div class="container col-4">
		<?php if ($error_message): ?>
		<div class="alert alert-danger alert-dismissible fade show" role="alert"><?= $error_message; ?><button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>
		<?php endif; ?>

		  <form action=""  method="post">

			<h4>Login Admin</h4>
			<p>Kelola Website</p>
			<div class="row">
			  <div class="col form-group">
				<input id="username" name="username" type="text" class="form-control" placeholder="Username">
			  </div>
			</div>
			<div class="row">
			  <div class="col form-group">
				<input id="password" name="password" type="password" class="form-control" placeholder="Password">
			  </div>
			</div>

			<div class="text-center">
			  <button type="submit" class="btn btn-primary">Login</button>
			  <!--<p class="mt-3 mb-0">Belum Punya Akun? <a href="./daftaradmin.php">Daftar Di Sini</a></p>-->
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

  </script>

</body>

</html>