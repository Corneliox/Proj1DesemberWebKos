<?php
session_start();
require_once 'config/helper.php';
require_once 'resources/views/template.php';

// Cek apakah pengguna sudah login
if (isset($_SESSION['user_logged_in'])) {
    header('Location: index.php');
    exit();
}

list($application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube) = settings();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Login - <?= htmlspecialchars($application_name); ?></title>
    <meta name="description" content="<?= htmlspecialchars($description); ?>">
    <meta name="keywords" content="<?= htmlspecialchars($keywords); ?>">

    <?= layout('css'); ?>
<style>
    /* Custom styles for full-page video background */
    .starter-page-page {
        padding: 0;
    }

    .video-background {
        position: fixed;
        top: 50%;
        left: 50%;
        min-width: 100%;
        min-height: 100%;
        width: auto;
        height: auto;
        z-index: -1;
        transform: translate(-50%, -50%);
        background: #000;
    }

    .comment-form {
        max-width: 400px;
        margin: 100px auto;
        background-color: rgba(255, 255, 255, 0.8);
        padding: 20px;
        border-radius: 10px;
        color: #333;
    }

    .comment-form h4, .comment-form p {
        text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.5);
    }
</style>
</head>

<body class="starter-page-page">

    <!-- Background Video -->
    <video autoplay muted loop class="video-background">
        <source src="video/animasi.mp4" type="video/mp4"> 
    </video>

    <header id="header" class="header d-flex align-items-center sticky-top">
        <div class="container-fluid container-xl position-relative d-flex align-items-center">
            <a href="./" class="logo d-flex align-items-center me-auto">
                <img src="assets/img/logo11.png" alt="">
                <h1 class="sitename"><?= htmlspecialchars($application_name); ?></h1>
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
                    <?php
                    if (isset($_SESSION['user_logged_in'])) {
                        echo '<li><a class="text-danger" href="javascript:void(0)">' . htmlspecialchars($_SESSION['user_name']) . '</a></li>';
                    } else {
                        echo '<li><a class="text-danger" href="javascript:void(0)">Guest</a></li>';
                    }
                    ?>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
            <?php
            if (isset($_SESSION['user_logged_in'])) {
                echo '<a class="btn-getstarted flex-md-shrink-0" href="./logout.php">Logout</a>';
            } else {
                echo '<a class="btn-getstarted flex-md-shrink-0" href="./login.php">Login</a>';
            }
            ?>
        </div>
    </header>

    <main class="main">

        <!-- Page Title -->
        <div class="page-title">
            <nav class="breadcrumbs">
                <div class="container">
                    <ol>
                        <li><a href="./">Beranda</a></li>
                        <li class="current">Daftar</li>
                    </ol>
                </div>
            </nav>
        </div><!-- End Page Title -->

        <!-- Comment Form Section -->
        <section id="comment-form" class="comment-form section">
            <div class="container">

                <form action="proseslogin.php" method="post">

                    <h4>Login</h4>
                    <p>Silahkan masuk</p>
                    <div class="row">
                        <div class="col form-group">
                            <input id="email" name="email" type="email" class="form-control" placeholder="Email" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col form-group">
                            <input id="password" name="password" type="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Login</button>
                        <p class="mt-3 mb-0">Belum Punya Akun? <a href="./daftar.php">Daftar Di Sini</a></p>
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
        // Optional JavaScript for functionality
    </script>

</body>

</html>
