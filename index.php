<?php
	session_start();

	//require_once 'config/connection.php';
	require_once 'config/helper.php';
	require_once 'resources/views/template.php';

	// session('all');
	list($application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube) = settings();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Beranda - <?= $application_name; ?></title>
  <meta name="description" content="<?= $description; ?>">
  <meta name="keywords" content="<?= $keywords; ?>">

  <?= layout('css'); ?>
  <style>
 
  </style>
</head>

<body class="index-page">

  <header id="header" class="header d-flex align-items-center fixed-top">
    <div class="container-fluid container-xl position-relative d-flex align-items-center">

      <a href="./" class="logo d-flex align-items-center me-auto">
        <!-- Uncomment the line below if you also wish to use an image logo -->
        <img src="assets/img/logo1.png" alt="">
        <h1 class="sitename"><?= $application_name; ?></h1>
      </a>

      <nav id="navmenu" class="navmenu">
        <ul>
          <li><a href="./" class="active">Beranda</a></li>
          <li class="dropdown"><a href="#"><span>Kost Ertiga</span> <i class="bi bi-chevron-down toggle-dropdown"></i></a>
            <ul>
              <li><a href="./kamarA.php">Kamar A</a></li>
			        <li><a href="./kamarA2.php">Kamar A2</a></li>
              <li><a href="./kamarB.php">Kamar B</a></li>
			        <li><a href="./kamarC.php">Kamar C</a></li>
              <li><a href="./kamarD.php">Kamar D</a></li>
            </ul>
          </li>
<?php
	if(isset($_SESSION['user_logged_in'])){
		echo '<li><a class="text-danger" href="javascript:void(0)">'.$_SESSION['user_name'].'</a></li>
		</ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
<a class="btn-getstarted flex-md-shrink-0" href="./logout.php">Logout</a>
';
	}else{
		echo '<li><a class="text-danger" href="javascript:void(0)">Guest</a></li>
		</ul>
        <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
      </nav>
<a class="btn-getstarted flex-md-shrink-0" href="./login.php">Login</a>
';
	}
?>

    </div>
  </header>

  <main class="main">

    <!-- Hero Section -->
    <section id="hero" class="hero section">

      <div class="container">
        <div class="row gy-4">
          <div class="col-lg-6 order-2 order-lg-1 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Selamat Datang di Wisma Purba Danarta</h1>
            <p data-aos="fade-up" data-aos-delay="100">Penginapan premium yang nyaman dan sejuk di tengah jantung Kota Semarang</p>
            <div class="d-flex flex-column flex-md-row" data-aos="fade-up" data-aos-delay="200">
              <a href="#about" class="btn-get-started">Pelajari Lebih Lanjut <i class="bi bi-arrow-right"></i></a>
              <!--<a href="https://www.youtube.com/watch?v=Y7f98aduVJ8" class="glightbox btn-watch-video d-flex align-items-center justify-content-center ms-0 ms-md-4 mt-4 mt-md-0"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>-->
            </div>
          </div>
          <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="gambar/ypd.png" class="img-fluid animated" alt="">
          </div>
        </div>
      </div>

    </section><!-- /Hero Section -->

    <!-- About Section -->
    <section id="about" class="about section">

      <div class="container" data-aos="fade-up">
        <div class="row gx-0">

          <div class="col-lg-6 d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="200">
            <div class="content">
              <h3>Tentang Kami</h3>
              <h2><?= $application_name; ?></h2>
              <p>
                Wisma Purba Danarta terletak di jantung kota Semarang. Dengan lingkungan yang asri dan lokasi yang sangat strategis, menjadikan Wisma Purba Danarta sebagai destinasi penginapan yang tepat untuk menemani liburan anda di kota Semarang.
              </p>
              <div class="text-center text-lg-start">
                <a href="./pemesanankamar.php" class="btn-read-more d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>Booking</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>

          <div class="col-lg-6 d-flex align-items-center" data-aos="zoom-out" data-aos-delay="200">
            <img src="assets/img/wismapb.jpg" class="img-fluid" alt="">
          </div>

        </div>
      </div>

    </section><!-- /About Section -->

    <!-- Values Section -->
    <section id="values" class="values section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Penginapan</h2>
        <p>Pilihan Kamar Kami<br></p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-4">

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="100">
            <div class="card">
              <img src="assets/img/A.jpg" class="img-fluid" alt="">
              <h3>Kamar A</h3>
              <p></p>
            </div>
          </div><!-- End Card Item -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="200">
            <div class="card">
              <img src="assets/img/A2.jpg" class="img-fluid" alt="">
              <h3>Kamar A2</h3>
              <p></p>
            </div>
          </div><!-- End Card Item -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card">
              <img src="assets/img/B.jpg" class="img-fluid" alt="">
              <h3>Kamar B</h3>
              <p></p>
            </div>
          </div><!-- End Card Item -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card">
              <img src="assets/img/C.jpg" class="img-fluid" alt="">
              <h3>Kamar C</h3>
              <p></p>
            </div>
          </div><!-- End Card Item -->

          <div class="col-lg-4" data-aos="fade-up" data-aos-delay="300">
            <div class="card">
              <img src="assets/img/D.jpg" class="img-fluid" alt="">
              <h3>Kamar D</h3>
              <p></p>
            </div>
          </div><!-- End Card Item -->

        </div>

      </div>

    </section>
    <section id="features" class="features section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Fasilitas</h2>
        <p>Fasilitas Penginapan Kami<br></p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">

         <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-out">
            <img src="gambar/icon.jpg" class="img-fluid animated" alt="">
          </div>

          <div class="col-xl-6 d-flex">
            <div class="row align-self-center gy-4">

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="200">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>AC/Fan</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Kamar Mandi</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="400">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Air Panas</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="500">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Parkir Luas</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="600">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>TV</h3>
                </div>
              </div><!-- End Feature Item -->

              <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Makan Pagi</h3>
                </div>
              </div><!-- End Feature Item -->

			  <div class="col-md-6" data-aos="fade-up" data-aos-delay="800">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Dapur</h3>
                </div>
              </div><!-- End Feature Item -->

			  <div class="col-md-6" data-aos="fade-up" data-aos-delay="700">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Dan Lainnya</h3>
                </div>
              </div><!-- End Feature Item -->

            </div>
          </div>

        </div>

      </div>

    </section>
    <section id="recent-posts" class="recent-posts section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Booking</h2>
        <p>Booking Kamar Sekarang</p>
      </div><!-- End Section Title -->

      <div class="container">

        <div class="row gy-5">

          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img src="assets/img/A.jpg" class="img-fluid" alt="">
                <span class="post-date">A</span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">Kamar A</h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                  <!-- Change Here -->
                    <?php
                      include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
                      $sql = "SELECT * FROM kamar WHERE tipe_kamar = 'A'";
                      $result = $conn->query($sql);
                      $data = $result->fetch_assoc();
                    ?>
                    <i class="bi bi-cash-stack"></i> <span class="ps-2">Rp <?= number_format($data['harga_per_malam'],2,',','.'); ?> </span>
                  <!-- Change Stop Here -->
                  </div>
                  <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-moon-stars-fill"></i> <span class="ps-2">Bulan</span>
                  </div>
                </div>

                <hr>

                <a href="./kamarA.php" class="readmore stretched-link"><span>Pesan Sekarang</span><i class="bi bi-arrow-right"></i></a>

              </div>

            </div>
          </div><!-- End post item -->

          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img src="assets/img/A2.jpg" class="img-fluid" alt="">
                <span class="post-date">A2</span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">Kamar A2</h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <!-- Change Here -->
                    <?php
                      include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
                      $sql = "SELECT * FROM kamar WHERE tipe_kamar = 'A2'";
                      $result = $conn->query($sql);
                      $data = $result->fetch_assoc();
                    ?>
                    <i class="bi bi-cash-stack"></i> <span class="ps-2">Rp <?= number_format($data['harga_per_malam'],2,',','.'); ?></span>
                    <!-- Change Stop Here -->
                  </div>
                  <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-moon-stars-fill"></i> <span class="ps-2">Bulan</span>
                  </div>
                </div>

                <hr>

                <a href="./kamarA2.php" class="readmore stretched-link"><span>Pesan Sekarang</span><i class="bi bi-arrow-right"></i></a>

              </div>

            </div>
          </div><!-- End post item -->

          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img src="assets/img/B.jpg" class="img-fluid" alt="">
                <span class="post-date">B</span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">Kamar B</h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <!-- Change Start Here -->
                    <?php
                      include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
                      $sql = "SELECT * FROM kamar WHERE tipe_kamar = 'B'";
                      $result = $conn->query($sql);
                      $data = $result->fetch_assoc();
                    ?>
                    <i class="bi bi-cash-stack"></i> <span class="ps-2">Rp <?= number_format($data['harga_per_malam'],2,',','.'); ?></span>
                    <!-- Change End Here -->
                  </div>
                  <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-moon-stars-fill"></i> <span class="ps-2">Bulan</span>
                  </div>
                </div>

                <hr>

                <a href="./kamarB.php" class="readmore stretched-link"><span>Pesan Sekarang</span><i class="bi bi-arrow-right"></i></a>

              </div>

            </div>
          </div><!-- End post item -->

          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img src="assets/img/C.jpg" class="img-fluid" alt="">
                <span class="post-date">C</span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">Kamar C</h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <!-- Change Start Here -->
                    <?php
                      include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
                      $sql = "SELECT * FROM kamar WHERE tipe_kamar = 'C'";
                      $result = $conn->query($sql);
                      $data = $result->fetch_assoc();
                    ?>
                    <i class="bi bi-cash-stack"></i> <span class="ps-2">Rp <?= number_format($data['harga_per_malam'],2,',','.'); ?></span>
                    <!-- Change End Here -->
                  </div>
                  <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-moon-stars-fill"></i> <span class="ps-2">Bulan</span>
                  </div>
                </div>

                <hr>

                <a href="./kamarC.php" class="readmore stretched-link"><span>Pesan Sekarang</span><i class="bi bi-arrow-right"></i></a>

              </div>

            </div>
          </div><!-- End post item -->

          <div class="col-xl-4 col-md-6">
            <div class="post-item position-relative h-100" data-aos="fade-up" data-aos-delay="100">

              <div class="post-img position-relative overflow-hidden">
                <img src="assets/img/D.jpg" class="img-fluid" alt="">
                <span class="post-date">D</span>
              </div>

              <div class="post-content d-flex flex-column">

                <h3 class="post-title">Kamar D</h3>

                <div class="meta d-flex align-items-center">
                  <div class="d-flex align-items-center">
                    <!-- Change Start Here -->
                    <?php
                      include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
                      $sql = "SELECT * FROM kamar WHERE tipe_kamar = 'D'";
                      $result = $conn->query($sql);
                      $data = $result->fetch_assoc();
                    ?>
                    <i class="bi bi-cash-stack"></i> <span class="ps-2">Rp <?= number_format($data['harga_per_malam'],2,',','.'); ?></span>
                    <!-- Change End Here -->
                  </div>
                  <span class="px-3 text-black-50">/</span>
                  <div class="d-flex align-items-center">
                    <i class="bi bi-moon-stars-fill"></i> <span class="ps-2">Bulan</span>
                  </div>
                </div>

                <hr>

                <a href="./kamarD.php" class="readmore stretched-link"><span>Pesan Sekarang</span><i class="bi bi-arrow-right"></i></a>

              </div>

            </div>
          </div><!-- End post item -->

        </div>

      </div>

    </section><!-- /Recent Posts Section -->

    <!-- Contact Section -->
    <section id="contact" class="contact section">

      <!-- Section Title -->
      <div class="container section-title" data-aos="fade-up">
        <h2>Kontak</h2>
        <p>Kontak Kami</p>
      </div><!-- End Section Title -->

      <div class="container" data-aos="fade-up" data-aos-delay="100">

        <div class="row gy-4">

          <div class="col-lg-6">

            <div class="row gy-4">
              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="200">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Alamat</h3>
                  <p><?= $address; ?></p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="300">
                  <i class="bi bi-telephone"></i>
                  <h3>Telepon Kami</h3>
                  <p><?= $telephone; ?></p>
                  <p>-</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="400">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Kami</h3>
                  <p><?= $email; ?></p>
                  <p>-</p>
                </div>
              </div><!-- End Info Item -->

              <div class="col-md-6">
                <div class="info-item" data-aos="fade" data-aos-delay="500">
                  <i class="bi bi-clock"></i>
                  <h3>Open Hours</h3>
                  <p>Check In: 14:00 WIB</p>
                  <p>Check Out: 12:00 WIB</p>
                </div>
              </div><!-- End Info Item -->

            </div>

          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form" data-aos="fade-up" data-aos-delay="200">
              <div class="row gy-4">

                <div class="col-12 text-center">
                  <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1983.4828088531916!2d110.4055123!3d-7.0037744!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e708b731ad39417%3A0x8bdf4c3ec416195f!2sJl.%20Veteran%20No.7%2C%20Lempongsari%2C%20Kec.%20Gajahmungkur%2C%20Kota%20Semarang%2C%20Jawa%20Tengah%2050231!5e0!3m2!1sid!2sid!4v1695387606674" width="100%" height="357.5px" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>

              </div>
            </form>
          </div><!-- End Contact Form -->

        </div>

      </div>

    </section><!-- /Contact Section -->

  </main>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            color: black; /* Warna teks putih */
            font-family: Arial, sans-serif; /* Font yang lebih modern */
            text-align: center; /* Menyelaraskan semua teks di tengah */
            padding: 20px; /* Memberi jarak pada konten */
        }
        h3 {
            margin-top: 20px; /* Jarak atas untuk judul */
        }
        a {
            color: #4CAF50; /* Warna hijau untuk tautan */
            text-decoration: none; /* Menghilangkan garis bawah dari tautan */
        }
        a:hover {
            text-decoration: underline; /* Menambahkan garis bawah saat tautan dihover */
        }
    </style>
</head>
<body>
    <div class="informasi container">
        <h3>Ikuti Kami di Instagram</h3>
        <p>Instagram: <a href="https://www.instagram.com/yayasanpurbadanarta" target="_blank">@yayasanpurbadanarta</a></p>

        <h3>Ikuti Kami di TikTok</h3>
<p>TikTok: <a href="https://www.tiktok.com/@wisma.purba.danar" target="_blank">@wisma.purba.danar</a></p>

    </div>
</body>
</html>

  <?= layout('footer'); ?><!-- End Footer -->

  <!-- Scroll Top -->
  <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <?= layout('js'); ?>

  <script type="text/javascript">

  </script>

</body>

</html>