<?php
	function layout($content, $page = '-'){
		global $mysqli, $application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube;

		switch($content){
			case 'css' :
				echo '<!-- Favicons -->
  <link href="./assets/img/favicon.ico" rel="icon">
  <link href="./assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com" rel="preconnect">
  <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&family=Nunito:ital,wght@0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="./assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="./assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="./assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="./assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="./assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">
  <link href="./assets/vendor/DataTables/datatables.min.css" rel="stylesheet">

  <!-- Main CSS File -->
  <link href="./assets/css/main.css" rel="stylesheet">
';
			break;

			case 'topnav' :
				echo '<div class="navbar-bg"></div>
			<nav class="navbar navbar-expand-lg main-navbar">
				<form class="form-inline mr-auto">
					<ul class="navbar-nav mr-3">
						<li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i class="fas fa-bars"></i></a></li>
						<!--<li><a href="#" data-toggle="search" class="nav-link nav-link-lg d-sm-none"><i class="fas fa-search"></i></a></li>-->
					</ul>
					<!--<div class="search-element">
						<input class="form-control" type="search" placeholder="Search" aria-label="Search" data-width="250">
						<button class="btn" type="submit"><i class="fas fa-search"></i></button>
						<div class="search-backdrop"></div>
						<!--<div class="search-result">
							<div class="search-header">
								Histories
							</div>
							<div class="search-item">
								<a href="#">How to hack NASA using CSS</a>
								<a href="#" class="search-close"><i class="fas fa-times"></i></a>
							</div>
							<div class="search-item">
								<a href="#">#Stisla</a>
								<a href="#" class="search-close"><i class="fas fa-times"></i></a>
							</div>
							<div class="search-header">
								Result
							</div>
							<div class="search-item">
								<a href="#">
									<img class="mr-3 rounded" width="30" src="assets/img/products/product-3-50.png" alt="product">
									oPhone S9 Limited Edition
								</a>
							</div>
							<div class="search-item">
								<a href="#">
									<img class="mr-3 rounded" width="30" src="assets/img/products/product-2-50.png" alt="product">
									Drone X2 New Gen-7
								</a>
							</div>
							<div class="search-header">
								Projects
							</div>
							<div class="search-item">
								<a href="#">
									<div class="search-icon bg-danger text-white mr-3">
										<i class="fas fa-code"></i>
									</div>
									Stisla Admin Template
								</a>
							</div>
							<div class="search-item">
								<a href="#">
									<div class="search-icon bg-primary text-white mr-3">
										<i class="fas fa-laptop"></i>
									</div>
									Create a new Homepage Design
								</a>
							</div>
						</div>
					</div>-->
				</form>
				<ul class="navbar-nav navbar-right">
					<!--<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link nav-link-lg message-toggle beep"><i class="far fa-envelope"></i></a>
						<div class="dropdown-menu dropdown-list dropdown-menu-right">
							<div class="dropdown-header">Messages
								<div class="float-right">
									<a href="#">Mark All As Read</a>
								</div>
							</div>
							<div class="dropdown-list-content dropdown-list-message">
								<a href="#" class="dropdown-item dropdown-item-unread">
									<div class="dropdown-item-avatar">
										<img alt="image" src="assets/img/avatar/avatar-1.png" class="rounded-circle">
										<div class="is-online"></div>
									</div>
									<div class="dropdown-item-desc">
										<b>Kusnaedi</b>
										<p>Hello, Bro!</p>
										<div class="time">10 Hours Ago</div>
									</div>
								</a>
								<a href="#" class="dropdown-item dropdown-item-unread">
									<div class="dropdown-item-avatar">
										<img alt="image" src="assets/img/avatar/avatar-2.png" class="rounded-circle">
									</div>
									<div class="dropdown-item-desc">
										<b>Dedik Sugiharto</b>
										<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit</p>
										<div class="time">12 Hours Ago</div>
									</div>
								</a>
							</div>
							<div class="dropdown-footer text-center">
								<a href="#">View All <i class="fas fa-chevron-right"></i></a>
							</div>
						</div>
					</li>
					<li class="dropdown dropdown-list-toggle"><a href="#" data-toggle="dropdown" class="nav-link notification-toggle nav-link-lg beep"><i class="far fa-bell"></i></a>
						<div class="dropdown-menu dropdown-list dropdown-menu-right">
							<div class="dropdown-header">Notifications
								<div class="float-right">
									<a href="#">Mark All As Read</a>
								</div>
							</div>
							<div class="dropdown-list-content dropdown-list-icons">
								<a href="#" class="dropdown-item dropdown-item-unread">
									<div class="dropdown-item-icon bg-primary text-white">
										<i class="fas fa-code"></i>
									</div>
									<div class="dropdown-item-desc">
										Template update is available now!
										<div class="time text-primary">2 Min Ago</div>
									</div>
								</a>
								<a href="#" class="dropdown-item">
									<div class="dropdown-item-icon bg-info text-white">
										<i class="far fa-user"></i>
									</div>
									<div class="dropdown-item-desc">
										<b>You</b> and <b>Dedik Sugiharto</b> are now friends
										<div class="time">10 Hours Ago</div>
									</div>
								</a>
							</div>
							<div class="dropdown-footer text-center">
								<a href="#">View All <i class="fas fa-chevron-right"></i></a>
							</div>
						</div>
					</li>-->
					<li class="dropdown"><a href="#" data-toggle="dropdown" class="nav-link dropdown-toggle nav-link-lg nav-link-user">
						<img alt="image" src="./images/photos/' . $_SESSION['photo'] . '" class="rounded-circle mr-1" id="nav-photo">
						<div class="d-sm-none d-lg-inline-block" id="nav-name">' . $_SESSION['name'] . '</div></a>
						<div class="dropdown-menu dropdown-menu-right">
							<div class="dropdown-title" id="nav-username">Halo ' . $_SESSION['username'] . '!</div>
							<a href="./profil" class="dropdown-item has-icon">
								<i class="fas fa-user"></i> Profil
							</a>
							' . (($_SESSION['level'] == 'admin') ? '
							<a href="javascript:void(0)" class="dropdown-item has-icon text-primary" id="btn-setelan" data-toggle="modal" data-target="#modal-setelan" data-backdrop="static" data-keyboard="false">
								<i class="fas fa-cog"></i> Setelan
							</a>
							' : '') . '
							<div class="dropdown-divider"></div>
							<a href="javascript:void(0)" class="dropdown-item has-icon text-danger logout">
								<i class="fas fa-sign-out-alt"></i> Keluar
							</a>
						</div>
					</li>
				</ul>
			</nav>
			<!-- Modal Setelan -->
			<div class="modal fade" id="modal-setelan" tabindex="-1" role="dialog" aria-labelledby="modal-info" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title">Setelan Website</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form id="form-setelan" class="needs-validation" novalidate="">
						<div class="modal-body pt-4">
							<div class="form-group mb-2">
								<label for="setelan-mode">Mode Website</label>
								<select class="form-control required" id="setelan-mode" name="mode" required>
									<option value="" selected hidden>― Pilih Mode ―</option>
									<option value="haki">HAKI</option>
									<option value="instansi">Instansi</option>
								</select>
								<div class="invalid-feedback">
									mode website tidak boleh kosong
								</div>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
							<button type="submit" class="btn btn-primary btn-save">Simpan</button>
						</div>
						</form>
					</div>
				</div>
			</div>
';
			break;

			case 'sidenav' :
				echo '<div class="main-sidebar sidebar-style-2">
				<aside id="sidebar-wrapper">
					<div class="sidebar-brand">
						<a href="./" class="d-inline-flex align-items-center"><img class="mr-2" src="./images/logo-color.png" style="max-width: 40px;">' . $header . '</a>
					</div>
					<div class="sidebar-brand sidebar-brand-sm">
						<a href="./"><img class="" src="./images/logo-color.png" style="max-width: 40px;"></a>
					</div>
					<ul class="sidebar-menu">
						<li class="menu-header">Menu</li>
						<li><a class="nav-link" href="./"><i class="fas fa-home"></i> <span>Dashboard</span></a></li>
						' . (($_SESSION['level'] == 'admin') ? '
						<li class="dropdown">
							<a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-database"></i> <span>Master</span></a>
							<ul class="dropdown-menu">
								<li><a class="nav-link" href="./klasifikasi">Klasifikasi Arsip</a></li>
							</ul>
						</li>
						' : '') . '
						<li><a class="nav-link" href="./arsip"><i class="fas fa-folder-open"></i> <span>Arsip</span></a></li>
						<li class="menu-header" id="side-level">' . $_SESSION['level'] . '</li>
						' . (($_SESSION['level'] == 'admin') ? '
						<li><a class="nav-link" href="./akun"><i class="fas fa-users"></i> <span>Akun</span></a></li>
						' : '') . '
						<li><a class="nav-link" href="./profil"><i class="fas fa-user"></i> <span>Profil</span></a></li>
					</ul>

					<div class="mt-4 mb-4 p-3 hide-sidebar-mini">
						<a href="javascript:void(0)" class="btn btn-primary btn-lg btn-block btn-icon-split logout">
							<i class="fas fa-sign-out-alt"></i> Keluar
						</a>
					</div>
				</aside>
			</div>
';
			break;

			case 'header' :
				echo '<section class="breadcrumbs">
			<div class="container">

				<ol>
					<li><a href="./">Beranda</a></li>
					<li>' . $page . '</li>
				</ol>
				<h2>' . $page . '</h2>

			</div>
		</section>
';
			break;

			case 'footer' :
				echo '<footer id="footer" class="footer">

    <!--<div class="footer-newsletter">
      <div class="container">
        <div class="row justify-content-center text-center">
          <div class="col-lg-6">
            <h4>Join Our Newsletter</h4>
            <p>Subscribe to our newsletter and receive the latest news about our products and services!</p>
            <form action="forms/newsletter.php" method="post" class="php-email-form">
              <div class="newsletter-form"><input type="email" name="email"><input type="submit" value="Subscribe"></div>
              <div class="loading">Loading</div>
              <div class="error-message"></div>
              <div class="sent-message">Your subscription request has been sent. Thank you!</div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <div class="container footer-top">
      <div class="row gy-4">
        <div class="col-lg-4 col-md-6 footer-about">
          <a href="index.html" class="d-flex align-items-center">
            <span class="sitename">' . $footer . '</span>
          </a>
          <div class="footer-contact pt-3">
            <p>' . $address . '</p>
            <p class="mt-3"><strong>Phone:</strong> <span>' . $telephone . '</span></p>
            <p><strong>Email:</strong> <span>' . $email . '</span></p>
          </div>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Link Situs</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="./">Beranda</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">About us</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Services</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="#">Terms of service</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-3 footer-links">
          <h4>Sosial Media</h4>
          <ul>
            <li><i class="bi bi-chevron-right"></i> <a href="' . $instagram . '">Instagram</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="' . $website . '">Website</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="mailto:' . $email . '">Email</a></li>
            <li><i class="bi bi-chevron-right"></i> <a href="callto:' . $telephone . '">Telepon</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-12">
          <h4>Kontak Kami</h4>
          <p>Penginapan premium yang nyaman dan sejuk di tengah jantung Kota Semarang</p>
          <div class="social-links d-flex">
            <a href="' . $instagram . '"><i class="bi bi-instagram"></i></a>
            <a href="' . $website . '"><i class="bi bi-globe"></i></a>
            <a href="mailto:' . $email . '"><i class="bi bi-envelope"></i></a>
            <a href="callto:' . $telephone . '"><i class="bi bi-telephone"></i></a>
          </div>
        </div>

      </div>
    </div>-->

    <div class="container copyright text-center mt-4">
      <p>© <span>Copyright ' . date('Y') . '</span> <strong class="px-1 sitename">' . $application_name . '</strong></p>
    </div>

  </footer>
';
			break;

			case 'js' :
				echo '<!-- Vendor JS Files -->
  <script src="./assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="./assets/vendor/php-email-form/validate.js"></script>
  <script src="./assets/vendor/aos/aos.js"></script>
  <script src="./assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="./assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="./assets/vendor/imagesloaded/imagesloaded.pkgd.min.js"></script>
  <script src="./assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="./assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="./assets/vendor/DataTables/datatables.min.js"></script>
  <script src="./assets/vendor/chart.min.js"></script>
  <script src="./assets/vendor/inputmask/jquery.inputmask.min.js"></script>

  <!-- Main JS File -->
  <script src="./assets/js/main.js"></script>
';
			break;
		}
	}
?>