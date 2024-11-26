<?php
session_start();

//require_once 'config/connection.php';
require_once 'config/helper.php';
require_once 'resources/views/template.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location:loginadmin.php');
    exit();
}
list($application_name, $author, $description, $keywords, $creator, $version, $title, $header, $footer, $address, $telephone, $facsimile, $email, $whatsapp, $website, $facebook, $instagram, $twitter, $youtube) = settings();

include 'koneksi.php'; // Pastikan Anda memiliki koneksi database
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Transaksi - <?= $application_name; ?></title>
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
                <li><a href="./list.php" class="active">List</a></li>
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
                    <li class="current">Transaksi</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <!-- Starter Section Section -->
    <section id="starter-section" class="starter-section section">

        <!-- Section Title -->
        <div class="container section-title" data-aos="fade-up">
            <h2>Transaksi</h2>
            <p>Kelola Data Transaksi</p>
        </div><!-- End Section Title -->

        <div class="container" data-aos="fade-up">
            <table id="myTable" class="table table-bordered table-striped" style="width: 100%;">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Transaksi</th>
                        <th>Tanggal</th>
                        <th>Pelanggan</th>
                        <th>Pembayaran</th>
                        <th>Invoice</th>
                        <th>Status</th>
                        <th>Remarks</th> <!-- Tambahkan kolom Remarks -->
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $no = 1;
                    $sql = "SELECT * FROM transaksi ORDER BY referenceId DESC";
                    $result = $conn->query($sql);
                    while($data = $result->fetch_assoc()){
                    ?>
                    <tr>
                        <td><?= $no++; ?></td>
                        <td><?= $data['referenceId']; ?></td>
                        <td><?= $data['timestamp']; ?></td>
                        <td><?= $data['userName']; ?></td>
                        <td>Rp <?= $data['payAmount']; ?></td>
                        <td><?= $data['invoiceId']; ?></td>
                        <td><?= $data['status']; ?></td>
                        <td><?= $data['remarks']; ?></td> <!-- Tampilkan data Remarks -->
                        <td>
                            <a class="btn btn-success" href="./edittransaksi.php?id=<?= $data['referenceId']; ?>"><i class='fa fa-edit'></i> Edit</a>
                            <a class="btn btn-danger" href="./hapustransaksi.php?id=<?= $data['referenceId']; ?>" onclick="return confirm('Anda Yakin Ingin Menghapus Data Ini?')"><i class='fa fa-trash'></i> Hapus</a>
                        </td>
                    </tr>
                    <?php
                    }
                    ?>
                </tbody>
            </table>
        </div>

    </section><!-- /Starter Section Section -->

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
