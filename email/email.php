<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Pembayaran dan Tiket - Kost Ertiga Ngaliyan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-gray-700 border-b-2 border-gray-300 pb-4 mb-4">Invoice Pembayaran</h1>
        <div class="flex justify-between mb-6">
            <div>
                <p class="text-lg font-semibold text-gray-700">Pelanggan: <span class="font-normal"><?php echo htmlspecialchars($row['userName']); ?></span></p>
                <p class="text-lg font-semibold text-gray-700">Email: <span class="font-normal"><?php echo htmlspecialchars($row['userEmail']); ?></span></p>
                <p class="text-lg font-semibold text-gray-700">Nomor Telepon: <span class="font-normal"><?php echo htmlspecialchars($row['userPhone']); ?></span></p>
            </div>
            <div>
                <p class="text-lg font-semibold text-gray-700">Tanggal: <span class="font-normal"><?php echo date('Y-m-d'); ?></span></p>
                <p class="text-lg font-semibold text-gray-700">Invoice #: <span class="font-normal">INV-<?php echo htmlspecialchars($referenceId); ?></span></p>
            </div>
        </div>
        <p class="text-gray-600">Terima kasih atas pembayaran Anda. Transaksi Anda berhasil.</p>
    </div>

    <div class="max-w-2xl mx-auto bg-gradient-to-r from-green-200 to-green-300 rounded-lg shadow-lg p-6">
        <h2 class="text-2xl font-semibold text-gray-800 mb-4">Tiket Pemesanan Kamar - Kost Ertiga Ngaliyan</h2>
        <div class="flex justify-between mb-2">
            <span class="font-bold text-gray-700">Tipe Kamar:</span>
            <span class="text-gray-700"><?php echo htmlspecialchars($row['tipe_kamar']); ?></span>
        </div>
        <div class="flex justify-between mb-2">
            <span class="font-bold text-gray-700">Tanggal Check-in:</span>
            <span class="text-gray-700"><?php echo htmlspecialchars($row['checkin']); ?></span>
        </div>
        <div class="flex justify-between mb-2">
            <span class="font-bold text-gray-700">Tanggal Check-out:</span>
            <span class="text-gray-700"><?php echo htmlspecialchars($row['checkout']); ?></span>
        </div>
        <div class="flex justify-between mb-4">
            <span class="font-bold text-gray-700">Total Harga:</span>
            <span class="text-gray-700">Rp <?php echo number_format($row['total_harga'], 0, ',', '.'); ?>,-</span>
        </div>
        <div class="bg-green-500 text-white font-bold text-center py-3 rounded-md text-lg">
            Reference ID: <?php echo htmlspecialchars($referenceId); ?>
        </div>
    </div>
</body>
</html>
