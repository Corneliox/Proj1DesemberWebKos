<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: loginadmin.php');
    exit();
}

include 'koneksi.php';

$id = $_GET['id'] ?? null;
$transaksi = null;
$error_message = '';
$success = false;

// Ambil data transaksi berdasarkan ID
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM transaksi WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaksi = $result->fetch_assoc();

    if (!$transaksi) {
        $error_message = 'Data transaksi tidak ditemukan.';
    }
}

// Proses form edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $tipe_kamar = $_POST['tipe_kamar'];
    $tanggal_mulai = $_POST['tanggal_mulai'];
    $tanggal_selesai = $_POST['tanggal_selesai'];
    $status_pemesanan = $_POST['status_pemesanan'];

    if ($id) {
        $stmt = $conn->prepare("
            UPDATE transaksi 
            SET jumlah_kamar = ?, tipe_kamar = ?, tanggal_mulai = ?, tanggal_selesai = ?, status_pemesanan = ?
            WHERE id = ?
        ");
        $stmt->bind_param("issssi", $jumlah_kamar, $tipe_kamar, $tanggal_mulai, $tanggal_selesai, $status_pemesanan, $id);

        if ($stmt->execute()) {
            $success = true;
            header('Location: list.php');
            exit();
        } else {
            $error_message = 'Terjadi kesalahan saat memperbarui data transaksi.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Transaksi - Kost Ertiga Ngaliyan</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .edit-form-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 30px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }
    </style>
</head>
<body>

<div class="container edit-form-container">
    <h2>Edit Transaksi</h2>

    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <?php if ($transaksi): ?>
        <form action="editpemesanan.php?id=<?= $id ?>" method="POST">
            <div class="form-group">
                <label for="jumlah_kamar">Jumlah Kamar</label>
                <input type="number" class="form-control" id="jumlah_kamar" name="jumlah_kamar" value="<?= htmlspecialchars($transaksi['jumlah_kamar']) ?>" required>
            </div>

            <div class="form-group">
                <label for="tipe_kamar">Tipe Kamar</label>
                <input type="text" class="form-control" id="tipe_kamar" name="tipe_kamar" value="<?= htmlspecialchars($transaksi['tipe_kamar']) ?>" required>
            </div>

            <div class="form-group">
                <label for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" class="form-control" id="tanggal_mulai" name="tanggal_mulai" value="<?= htmlspecialchars($transaksi['tanggal_mulai']) ?>" required>
            </div>

            <div class="form-group">
                <label for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" class="form-control" id="tanggal_selesai" name="tanggal_selesai" value="<?= htmlspecialchars($transaksi['tanggal_selesai']) ?>" required>
            </div>

            <div class="form-group">
                <label for="status_pemesanan">Status Pemesanan</label>
                <select class="form-control" id="status_pemesanan" name="status_pemesanan" required>
                    <option value="Pending" <?= ($transaksi['status_pemesanan'] === 'Pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="Confirmed" <?= ($transaksi['status_pemesanan'] === 'Confirmed') ? 'selected' : '' ?>>Confirmed</option>
                    <option value="Canceled" <?= ($transaksi['status_pemesanan'] === 'Canceled') ? 'selected' : '' ?>>Canceled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
            <a href="list.php" class="btn btn-secondary btn-block mt-2">Kembali</a>
        </form>
    <?php else: ?>
        <p>Data transaksi tidak ditemukan.</p>
        <a href="list.php" class="btn btn-secondary btn-block mt-2">Kembali</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
