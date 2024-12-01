<?php
session_start();
require_once 'config/helper.php';
include 'koneksi.php'; // Pastikan Anda memiliki koneksi database

// Cek apakah pengguna sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: loginadmin.php');
    exit();
}

// Cek apakah id transaksi sudah diberikan
if (isset($_GET['id'])) {
    $referenceId = $_GET['id'];

    // Mempersiapkan statement untuk menghapus transaksi
    $sql = "DELETE FROM transaksi WHERE referenceId = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $referenceId);

    // Menjalankan query
    if ($stmt->execute()) {
        // Redirect kembali ke halaman transaksi dengan pesan sukses
        $_SESSION['message'] = "Transaksi berhasil dihapus.";
        header('Location: transaksi.php');
        exit();
    } else {
        // Redirect kembali ke halaman transaksi dengan pesan error
        $_SESSION['message'] = "Gagal menghapus transaksi.";
        header('Location: transaksi.php');
        exit();
    }
} else {
    // Jika id tidak diberikan, redirect ke halaman transaksi
    header('Location: transaksi.php');
    exit();
}
?>
