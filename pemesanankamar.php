<?php
session_start();

// Cek apakah pengguna sudah login
if (!isset($_SESSION['user_logged_in'])) {
    header('Location:login.php');
    exit();
}

require_once 'resources/views/template.php';
include 'koneksi.php'; // Pastikan Anda memiliki koneksi database

// Proses pemesanan kamar
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'];
    $nama = $_POST['name'];
    $telepon = $_POST['phone'];
    $email = $_POST['email'];
    $tipe_kamar = $_POST['room_type'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $jumlah_kamar = $_POST['room_count'];
	$harga_per_malam = $_POST['harga_per_malam'];

    // Cek apakah tanggal check-out valid
    if (strtotime($checkout) <= strtotime($checkin)) {
        echo "Tanggal check-out harus setelah tanggal check-in.";
        exit();
    }

    // Harga per malam berdasarkan tipe kamar
    /* switch ($tipe_kamar) {
        case 'Ekonomi':
            $harga_per_malam = 110000;
            break;
        case 'Standart':
            $harga_per_malam = 165000;
            break;
        case 'Deluxe':
            $harga_per_malam = 220000;
            break;
        default:
            echo "Tipe kamar tidak valid.";
            exit();
    } */

    // Cek Jumlah Kamar
    $sql_kamar = "SELECT jumlah FROM kamar WHERE tipe_kamar = :tipe_kamar";
    $stmt_kamar = $conn->prepare($sql_kamar);
    $stmt_kamar->bindParam(':tipe_kamar', $tipe_kamar);
    $stmt_kamar->execute();
    $kamar_data = $stmt_kamar->fetch(PDO::FETCH_ASSOC);

    // Hitung jumlah hari menginap
    $dayCount = (strtotime($checkout) - strtotime($checkin)) / (60 * 60 * 24);
    $total_harga = $jumlah_kamar * $harga_per_malam * $dayCount;

    // Simpan data pemesanan ke database
    $sql = "INSERT INTO pemesanan (user_id, nama, telepon, email, tipe_kamar, jumlah_kamar, checkin, checkout, total_harga) 
            VALUES (:user_id, :nama, :telepon, :email, :tipe_kamar, :jumlah_kamar, :checkin, :checkout, :total_harga)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':nama', $nama);
    $stmt->bindParam(':telepon', $telepon);
    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':tipe_kamar', $tipe_kamar);
    $stmt->bindParam(':jumlah_kamar', $jumlah_kamar);
    $stmt->bindParam(':checkin', $checkin);
    $stmt->bindParam(':checkout', $checkout);
    $stmt->bindParam(':total_harga', $total_harga);

    if ($stmt->execute()) {
        // Kurangi kamar dulu ya bosku wkkwkwk
        $sql_update_kamar = "UPDATE kamar SET jumlah = jumlah - :jumlah_kamar WHERE tipe_kamar = :tipe_kamar";
        $stmt_update_kamar = $conn->prepare($sql_update_kamar);
        $stmt_update_kamar->bindParam(':jumlah_kamar', $jumlah_kamar);
        $stmt_update_kamar->bindParam(':tipe_kamar', $tipe_kamar);
        $stmt_update_kamar->execute();

        // Redirect ke invoice.php setelah pemesanan berhasil
        header("Location: invoice.php?user_id=$user_id&total_harga=$total_harga&tipe_kamar=$tipe_kamar&jumlah_kamar=$jumlah_kamar&checkin=$checkin&checkout=$checkout");
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
    <h2>Pemesanan Kamar</h2>
    <h3>Isi form berikut untuk melakukan pemesanan kamar</h3>
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
            <label for="checkin">Tanggal Check-in:</label>
            <input type="date" class="form-control" id="checkin" name="checkin" required>
        </div>
        <div class="form-group">
            <label for="checkout">Tanggal Check-out:</label>
            <input type="date" class="form-control" id="checkout" name="checkout" required>
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
                    {$data['tipe_kamar']} (Rp " . number_format($data['harga_per_malam'], 2, ',', '.') . " per malam)
                    </option>";
            }
            ?>
            </select>
			<!-- <input type="hidden" class="form-control" id="harga_per_malam" name="harga_per_malam" value="" required> -->
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
$(document).ready(function() {
    $('#room_type').on('change', function() {
        let harga = $('#room_type option:selected').attr('data-harga');
        $('#harga_per_malam').val(harga);
        updateTotalPrice();
    });

    $('#room_count, #checkin, #checkout').on('input change', function() {
        updateTotalPrice();
    });
});

const totalPriceElement = document.getElementById('total_price');

function calculateDayCount(checkInDate, checkOutDate) {
    const checkIn = new Date(checkInDate);
    const checkOut = new Date(checkOutDate);

    // Pastikan tanggal check-out valid
    if (isNaN(checkIn.getTime()) || isNaN(checkOut.getTime()) || checkOut <= checkIn) {
        return 0;
    }

    const timeDiff = checkOut - checkIn;
    return Math.ceil(timeDiff / (1000 * 60 * 60 * 24)); // Konversi dari milidetik ke hari
}

function updateTotalPrice() {
    const roomTypeSelect = document.getElementById('room_type');
    const roomCount = parseInt(document.getElementById('room_count').value) || 0;
    const checkInDate = document.getElementById('checkin').value;
    const checkOutDate = document.getElementById('checkout').value;
    const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
    const hargaPerMalam = parseInt(selectedOption.getAttribute('data-harga')) || 0;

    if (roomCount > 0 && checkInDate && checkOutDate && hargaPerMalam > 0) {
        const dayCount = calculateDayCount(checkInDate, checkOutDate);

        if (dayCount > 0) {
            const totalPrice = hargaPerMalam * roomCount * dayCount;
            totalPriceElement.textContent = `Rp ${totalPrice.toLocaleString('id-ID')},-`;
        } else {
            totalPriceElement.textContent = 'Rp 0,-';
        }
    } else {
        totalPriceElement.textContent = 'Rp 0,-';
    }
}

document.addEventListener("DOMContentLoaded", function () {
        const roomTypeSelect = document.getElementById("room_type");
        const roomCountInput = document.getElementById("room_count");

        roomTypeSelect.addEventListener("change", function () {
            const selectedOption = roomTypeSelect.options[roomTypeSelect.selectedIndex];
            const maxRooms = selectedOption.getAttribute("data-max");

            if (maxRooms) {
                roomCountInput.removeAttribute("disabled"); // Aktifkan input jumlah kamar
                roomCountInput.setAttribute("max", maxRooms); // Set nilai maksimum
                roomCountInput.setAttribute("min", 1); // Pastikan minimum tetap 1
                roomCountInput.value = ""; // Kosongkan nilai input
            } else {
                roomCountInput.setAttribute("disabled", "disabled"); // Nonaktifkan input jika tidak ada tipe yang dipilih
            }
        });
    });

// Tambahkan event listener ke elemen input untuk menghitung harga secara dinamis
roomTypeInput.addEventListener('change', updateTotalPrice);
roomCountInput.addEventListener('input', updateTotalPrice);
checkInDateInput.addEventListener('change', updateTotalPrice);
checkOutDateInput.addEventListener('change', updateTotalPrice);

</script>

</body>
</html>