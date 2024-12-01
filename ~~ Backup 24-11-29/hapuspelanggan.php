<?php
session_start();

//require_once 'config/connection.php';
require_once 'config/helper.php';
require_once 'resources/views/template.php';

// Cek apakah pengguna sudah login
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: loginadmin.php');
    exit();
}

include 'koneksi.php'; // Pastikan Anda memiliki koneksi database

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Persiapkan pernyataan SQL untuk menghapus pengguna
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $delete = $stmt->affected_rows;

        if ($delete > 0) {
            $_SESSION['success'] = '<strong>Sukses!</strong> Data Pengguna Berhasil Dihapus.';
        } else {
            $_SESSION['error'] = '<strong>Error!</strong> Data Pengguna Gagal Dihapus. Mungkin data tidak ditemukan.';
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = '<strong>Error!</strong> Gagal menyiapkan pernyataan SQL.';
    }

    $conn->close();
    header('location: pelanggan.php');
    exit();
} else {
    $_SESSION['warning'] = '<strong>Peringatan!</strong> Pilih Data yang Ingin Dihapus.';
    header('location: pelanggan.php');
    exit();
}
