<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: loginadmin.php');
    exit();
}

include 'koneksi.php';

$id = $_GET['id'] ?? null;
$kamar = null;
$success = false;
$error_message = '';

// Ambil data kamar berdasarkan ID
if ($id) {
    $stmt = $conn->prepare("SELECT * FROM kamar WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $kamar = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$kamar) {
        $error_message = 'Kamar tidak ditemukan.';
    }
}

// Jika form di-submit
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $tipe_kamar = $_POST['tipe_kamar'];
    $harga_per_malam = $_POST['harga_per_malam'];

    // Update data kamar
    if ($id) {
        $stmt = $conn->prepare("UPDATE kamar SET tipe_kamar = :tipe_kamar, harga_per_malam = :harga_per_malam WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':tipe_kamar', $tipe_kamar);
        $stmt->bindParam(':harga_per_malam', $harga_per_malam);

        if ($stmt->execute()) {
            $success = true;
            header('Location: kamar.php');
            exit();
        } else {
            $error_message = 'Terjadi kesalahan saat memperbarui data kamar.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kamar - Wisma Purba Danarta</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        .edit-form-container {
            max-width: 500px;
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
    <h2>Edit Kamar</h2>

    <?php if ($error_message): ?>
        <div class="alert alert-danger"><?= $error_message ?></div>
    <?php endif; ?>

    <?php if ($kamar): ?>
        <form action="editkamar.php?id=<?= $id ?>" method="POST">
            <div class="form-group">
                <label for="tipe_kamar">Tipe Kamar</label>
                <select class="form-control" id="tipe_kamar" name="tipe_kamar" required>
                    <option value="Ekonomi" <?= ($kamar['tipe_kamar'] === 'Ekonomi') ? 'selected' : '' ?>>Ekonomi</option>
                    <option value="Standart" <?= ($kamar['tipe_kamar'] === 'Standart') ? 'selected' : '' ?>>Standart</option>
                    <option value="Deluxe" <?= ($kamar['tipe_kamar'] === 'Deluxe') ? 'selected' : '' ?>>Deluxe</option>
                </select>
            </div>

            <div class="form-group">
                <label for="harga_per_malam">Harga per Malam</label>
                <input type="number" class="form-control" id="harga_per_malam" name="harga_per_malam" value="<?= htmlspecialchars($kamar['harga_per_malam']) ?>" required>
            </div>

            <button type="submit" class="btn btn-primary btn-block">Simpan Perubahan</button>
            <a href="kamar.php" class="btn btn-secondary btn-block mt-2">Kembali</a>
        </form>
    <?php else: ?>
        <p>Kamar tidak ditemukan.</p>
        <a href="kamar.php" class="btn btn-secondary btn-block mt-2">Kembali</a>
    <?php endif; ?>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>