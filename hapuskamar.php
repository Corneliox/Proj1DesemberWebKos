<?php
	session_start();

	//require_once 'config/connection.php';
	require_once 'config/helper.php';
	require_once 'resources/views/template.php';

	//session('admin');
	// Cek apakah pengguna sudah login
	if (!isset($_SESSION['admin_logged_in'])) {
		header('Location:loginadmin.php');
		exit();
	}
	include 'koneksi.php'; // Pastikan Anda memiliki koneksi database

	if(isset($_GET['id'])){
		$id = $_GET['id'];

		$sql = "DELETE FROM kamar WHERE id = ?";
		$stmt = $conn->prepare($sql);
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$delete = $stmt->affected_rows;

		if($delete > 0){
			$_SESSION['success'] = '<strong>Sukses!</strong> Data Kamar Berhasil Dihapus.';
			header('location: kamar.php');
		}else{
			$_SESSION['error'] = '<strong>Error!</strong> Data Kamar Gagal Dihapus.';
			header('location: kamar.php');
		}
		$stmt->close();
		$conn->close();
	}else{
		$_SESSION['warning'] = '<strong>Peringatan!</strong> Pilih Data yang Ingin Dihapus.';
		header('location: kamar.php');
		exit();
	}
?>