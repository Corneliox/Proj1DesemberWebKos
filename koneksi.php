<?php
// Konfigurasi database
$host = 'localhost'; // Ganti jika server database bukan localhost
$username = 'mesy7597_purbadanarta2024'; // Username database
$password = 'arya2024'; // Password database
$database = 'mesy7597_purbadanarta'; // Nama database

// Membuat koneksi
$conn = mysqli_connect($host, $username, $password, $database);

// Memeriksa koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Cek apakah fungsi tutupKoneksi sudah ada
if (!function_exists('tutupKoneksi')) {
    // Fungsi untuk menutup koneksi
    function tutupKoneksi($conn) {
        mysqli_close($conn);
    }
}
?>
