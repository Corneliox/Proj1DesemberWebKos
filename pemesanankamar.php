<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_logged_in'])) {
    header('Location: login.php');
    exit();
}

require_once 'resources/views/template.php';
include 'koneksi.php'; // Koneksi ke database

// Proses pemesanan kamar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $nama = $_POST['name'];
    $telepon = $_POST['phone'];
    $email = $_POST['email'];
    $tipe_kamar = $_POST['room_type'];
    $bulan_mulai = $_POST['start_month'];
    $durasi_bulan = intval($_POST['duration']);
    $jumlah_kamar = intval($_POST['room_count']);
    $harga_per_bulan = intval($_POST['harga_per_bulan']);

    // Validasi ketersediaan kamar
    $cek_kamar_sql = "SELECT jumlah_kamar FROM kamar WHERE tipe_kamar = :tipe_kamar";
    $cek_stmt = $conn->prepare($cek_kamar_sql);
    $cek_stmt->bindParam(':tipe_kamar', $tipe_kamar);
    $cek_stmt->execute();
    $result = $cek_stmt->fetch(PDO::FETCH_ASSOC);

    if ($result['jumlah_kamar'] <= 0) {
        echo "Kamar sudah penuh.";
        exit();
    } elseif ($jumlah_kamar > $result['jumlah_kamar']) {
        echo "Jumlah kamar yang tersedia tidak mencukupi.";
        exit();
    }

    // Hitung total harga
    $total_harga = $jumlah_kamar * $harga_per_bulan * $durasi_bulan;

    // Simpan data pemesanan ke database
    $sql = "INSERT INTO pemesanan (user_id, nama, telepon, email, tipe_kamar, jumlah_kamar, bulan_mulai, durasi_bulan, total_harga) 
            VALUES (:user_id, :nama, :telepon, :email, :tipe_kamar, :jumlah_kamar, :bulan_mulai, :durasi_bulan, :total_harga)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':telepon', $telepon);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipe_kamar', $tipe_kamar);
    $stmt->bindParam(':jumlah_kamar', $jumlah_kamar);
    $stmt->bindParam(':bulan_mulai', $bulan_mulai);
    $stmt->bindParam(':durasi_bulan', $durasi_bulan);
    $stmt->bindParam(':total_harga', $total_harga);

    if ($stmt->execute()) {
        header("Location: invoice.php?user_id=$user_id&total_harga=$total_harga&tipe_kamar=$tipe_kamar&jumlah_kamar=$jumlah_kamar&bulan_mulai=$bulan_mulai&durasi_bulan=$durasi_bulan");
        exit();
    } else {
        echo "Terjadi kesalahan saat memproses pemesanan.";
    }
}
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pemesanan Kamar - Kost Ertiga Ngaliyan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('gambar/background.jpg');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
        .container {
            margin-top: 40px;
            background-color: rgba(255, 255, 255, 0.9);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
        }
        .btn-custom {
            background-color: #28a745;
            color: white;
            width: 100%;
        }
        .btn-custom:hover {
            background-color: #218838;
        }
        h2, h3 {
            text-align: center;
        }
        label {
            font-weight: bold;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-control {
            border-radius: 5px;
        }
        .total-price {
            font-size: 1.2em;
            color: #333;
            font-weight: bold;
        }
        .btn-back {
            position: absolute;
            right: 30px;
            bottom: 30px;
            display: inline-block;
        }
    </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="pemesanankamar.php">
        <img src="gambar/ypd1.png" alt="Logo" style="width: 80px; height: 80px; margin-right: 40px;">
        Kost Ertiga Ngaliyan
</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="kamarA.php">Kamar A</a></li>
            <li class="nav-item"><a class="nav-link" href="kamarA2.php">Kamar A2</a></li>
            <li class="nav-item"><a class="nav-link" href="kamarB.php">Kamar B</a></li>
            <li class="nav-item"><a class="nav-link" href="kamarC.php">Kamar C</a></li>
            <li class="nav-item"><a class="nav-link" href="kamarD.php">Kamar D</a></li>
            <?php if (!isset($_SESSION['user_logged_in'])) { ?>
                <li class="nav-item"><a class="nav-link" href="daftar.php">Daftar</a></li>
                <li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>
    <img src="gambar/logosiega.jpg" alt="Logo" style="width: 80px; height: 80px; margin-right: 40px;">
<!-- Form Pemesanan Kamar -->
<div class="container">
    <h2>Pemesanan Kost Bulanan</h2>
    <h3>Isi form berikut untuk memesan kost bulanan</h3>
    <form action="respon.php" method="post">
        <div class="form-group">
            <label for="name">Nama:</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Masukkan nama lengkap Anda" required>
        </div>
        <div class="form-group">
            <label for="phone">Nomor Handphone:</label>
            <input type="tel" class="form-control" id="phone" name="phone" placeholder="Masukkan nomor handphone aktif" required>
        </div>
        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Masukkan e-mail aktif Anda" required>
        </div>
        <div class="form-group">
            <label for="start_month">Bulan Mulai:</label>
            <input type="month" class="form-control" id="start_month" name="start_month" required>
        </div>
        <div class="form-group">
            <label for="duration">Durasi Kost (Bulan):</label>
            <input type="number" class="form-control" id="duration" name="duration" min="1" required>
        </div>
        <div class="form-group">
            <label for="room_type">Tipe Kamar:</label>
            <select class="form-control" id="room_type" name="room_type" required>
			<option value="" selected hidden>- Pilih Kamar -</option>
			<?php
            $sql = "SELECT * FROM kamar ORDER BY id DESC";
            $result = $conn->query($sql);
            while ($data = $result->fetch_assoc()) {
                echo "<option value='{$data['tipe_kamar']}' data-max='{$data['jumlah']}' data-harga='{$data['harga_per_malam']}'>
                    {$data['tipe_kamar']} (Rp " . number_format($data['harga_per_malam'], 2, ',', '.') . " per Bulan)
                    </option>";
            }
            ?>
            </select>
			<input type="hidden" class="form-control" id="harga_per_malam" name="harga_per_malam" value="" required>
        </div>
        <div class="form-group">
            <label for="room_count">Jumlah Kamar:</label>
            <input type="number" class="form-control" id="room_count" name="room_count" placeholder="Masukkan jumlah kamar yang ingin dipesan" min="1" disabled required>
        </div>


        <!-- Perhitungan harga -->
        <div class="form-group">
            <p>Total Harga: <span id="total_price" class="total-price">Rp 0,-</span></p>
        </div>

        <button type="submit" class="btn btn-custom">Pesan Sekarang</button>
    </form>

    <!-- Tombol Kembali -->
    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary btn-block">Kembali</a>
    </div>
</div>

<!-- Footer -->
<footer class="text-center mt-4">
    <p>&copy; 2024 Kost Ertiga Ngaliyan. All rights reserved.</p>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- JavaScript untuk menghitung harga -->
<script>
$(document).ready(function () {
    // Update price per month based on selected room type
    $('#room_type').on('change', function () {
        const selectedOption = $(this).find('option:selected');
        const harga = parseInt(selectedOption.attr('data-harga')) || 0; // Ensure the price is a number
        const maxRooms = parseInt(selectedOption.attr('data-max')) || 0; // Ensure maxRooms is a number

        // Set price per month
        $('#harga_per_malam').val(harga);

        // Set max room count
        const roomCountInput = $('#room_count');
        if (maxRooms > 0) {
            roomCountInput.prop('disabled', false);
            roomCountInput.attr('max', maxRooms);
            roomCountInput.attr('min', 1);
            roomCountInput.val(''); // Clear room count input
        } else {
            roomCountInput.prop('disabled', true);
        }

        // Update total price
        updateTotalPrice();
    });

    // Event listener to recalculate total price on input change
    $('#room_count, #start_month, #duration').on('input change', function () {
        updateTotalPrice();
    });
});

// Function to update total price
function updateTotalPrice() {
    const hargaPerBulan = parseInt($('#harga_per_malam').val()) || 0;
    const roomCount = parseInt($('#room_count').val()) || 0;
    const duration = parseInt($('#duration').val()) || 0;

    if (hargaPerBulan > 0 && roomCount > 0 && duration > 0) {
        const totalPrice = hargaPerBulan * roomCount * duration;
        $('#total_price').text(`Rp ${totalPrice.toLocaleString('id-ID')},-`);
    } else {
        $('#total_price').text('Rp 0,-');
    }
}
</script>
</body>
</html>