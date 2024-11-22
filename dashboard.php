<?php
	session_start();


	require_once 'config/helper.php';
	require_once 'resources/views/template.php';


	if (!isset($_SESSION['admin_logged_in'])) {
		header('Location:loginadmin.php');
		exit();
	}
	list($application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube) = settings();

	include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
	
	$sql = "SELECT (SELECT COUNT(*) FROM kamar) AS total_kamar, (SELECT COUNT(*) FROM transaksi) AS total_transaksi, (SELECT COUNT(*) FROM users) AS total_user, (SELECT COUNT(*) FROM admin) AS total_admin";
	$stmt = $conn->prepare($sql);
	$stmt->execute();
	$data = $stmt->get_result()->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Dashboard - <?= $application_name; ?></title>
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
      <li><a href="./editadmin.php" class="active">Edit Admin</a></li>
		  <li><a href="./checkin&checkout.php" class="active">checkin&checkout</a></li>
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
            <li><a href="./">Beranda</a></li>
            <li class="current">Dashboard</li>
          </ol>
        </div>
      </nav>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section pb-0">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Selamat Datang</h2>
        <p>Dashboard Admin Wisma Purba Danarta</p>
      </div><!-- End Section Title -->

      <!--<div class="container" data-aos="fade-up">
        <p>Use this page as a starter for your own custom pages.</p>
      </div>-->

    </section><!-- /Starter Section Section -->
	
	 <!-- Stats Section -->
    <section id="stats" class="stats section pt-0">

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="bi bi-houses color-blue flex-shrink-0"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?= $data['total_kamar']; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Kamar</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="bi bi-journal-richtext color-orange flex-shrink-0" style="color: #ee6c20;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?= $data['total_transaksi']; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Transaksi</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="bi bi-people-fill color-green flex-shrink-0" style="color: #15be56;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?= $data['total_user']; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Pelanggan</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="stats-item d-flex align-items-center w-100 h-100">
              <i class="bi bi-people color-pink flex-shrink-0" style="color: #bb0852;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?= $data['total_admin']; ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Admin</p>
              </div>
            </div>
          </div>

        </div>

      </div>

    </section><!-- /Stats Section -->

  </main>

  <?= layout('footer'); ?><!-- End Footer -->

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?= layout('js'); ?>

  <script type="text/javascript">

  </script>

</body>

</html>