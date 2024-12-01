<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: loginadmin.php');
    exit();
}

include 'koneksi.php';

$id = $_GET['id'] ?? null;
$pemesanan = null;
$error_message = '';
$success = false;

// Ambil data pemesanan berdasarkan ID
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM pemesanan WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $pemesanan = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$pemesanan) {
        $error_message = 'Pemesanan tidak ditemukan.';
    }
}

// Proses form edit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jumlah_kamar = $_POST['jumlah_kamar'];
    $checkin = $_POST['checkin'];
    $checkout = $_POST['checkout'];
    $status = $_POST['status'];

    if ($id) {
        $stmt = $conn->prepare("UPDATE pemesanan SET jumlah_kamar = :jumlah_kamar, checkin = :checkin, checkout = :checkout, status = :status WHERE id = :id");
        $stmt->bindParam(':jumlah_kamar', $jumlah_kamar);
        $stmt->bindParam(':checkin', $checkin);
        $stmt->bindParam(':checkout', $checkout);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            $success = true;
            header('Location: pemesanan.php');
            exit();
        } else {
            $error_message = 'Terjadi kesalahan saat memperbarui data pemesanan.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pemesanan - Wisma Purba Danarta</title>
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
    <h2>Edit Pemesanan</h2>

    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <?php if ($pemesanan): ?>
        <form action="editpemesanan.php?id=<?= $id ?>" method="POST">
            <div class="form-group">
                <label for="jumlah_kamar">Jumlah Kamar</label>
                <input type="number" class="form-control" id="jumlah_kamar" name="jumlah_kamar" value="<?= htmlspecialchars($pemesanan['jumlah_kamar']) ?>" required>
            </div>

            <div class="form-group">
                <label for="checkin">Tanggal Check-in</label>
                <input type="date" class="form-control" id="checkin" name="checkin" value="<?= htmlspecialchars($pemesanan['checkin']) ?>" required>
            </div>

            <div class="form-group">
                <label for="checkout">Tanggal Check-out</label>
                <input type="date" class="form-control" id="checkout" name="checkout" value="<?= htmlspecialchars($pemesanan['checkout']) ?>" required>
            </div>

            <div class="form-group">
                <label for="status">Status Pemesanan</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending" <?= ($pemesanan['status'] === 'pending') ? 'selected' : '' ?>>Pending</option>
                    <option value="confirmed" <?= ($pemesanan['status'] === 'confirmed') ? 'selected' : '' ?>>Confirmed</option>
                    <option value="canceled" <?= ($pemesanan['status'] === 'canceled') ? 'selected' : '' ?>>Canceled</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
            <a href="pemesanan.php" class="btn btn-secondary btn-block mt-2">Kembali</a>
        </form>
    <?php else: ?>
        <p>Pemesanan tidak ditemukan.</p>
        <a href="pemesanan.php" class="btn btn-secondary btn-block mt-2">Kembali</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>