<?php

session_start();

include "../koneksi.php";

// Mengambil data JSON dari request body
$data = file_get_contents('php://input');
$data_decode = json_decode($data, true);

// Mendeklarasikan variabel berdasarkan data JSON
$invoiceId = $data_decode['invoiceId'];
$paymentAccountId = $data_decode['paymentAccountId'];
$paymentAccountType = $data_decode['paymentAccountType'];
$paymentAccountNumber = $data_decode['paymentAccountNumber'];
$paymentAccountName = $data_decode['paymentAccountName'];
$amount = $data_decode['amount'];
$status = $data_decode['status'];

// Query untuk mendapatkan data transaksi berdasarkan invoiceId
$sql = "SELECT * FROM transaksi WHERE referenceId = '".$invoiceId."'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Menyimpan data transaksi ke session
    $_SESSION['referenceId'] = $row['referenceId'];
    $_SESSION['userName'] = $row['userName'];
    $_SESSION['userEmail'] = $row['userEmail'];
    $_SESSION['userPhone'] = $row['userPhone'];
    $_SESSION['tipe_kamar'] = $row['tipe_kamar'];
    $_SESSION['jumlah_kamar'] = $row['jumlah_kamar'];
    $_SESSION['tanggal_mulai'] = $row['tanggal_mulai'];
    $_SESSION['tanggal_selesai'] = $row['tanggal_selesai'];
    $_SESSION['durasi_bulan'] = $row['durasi_bulan'];
    $_SESSION['total_harga'] = $row['total_harga'];
    $_SESSION['status_pemesanan'] = $row['status_pemesanan'];
} else {
    $teks = "Error fetching transaction data: " . $conn->error;
    $myfile = fopen("error.txt", "a") or die("Unable to open file!");
    fwrite($myfile, $teks . "\n");
    fclose($myfile);
    exit(); // Menghentikan eksekusi jika terjadi error
}

// Mengirim email atau notifikasi lainnya
include "../email/sendmail.php";
include "../fonnte/index2.php";

// Update status transaksi menjadi 'PAID'
$sql = "UPDATE transaksi SET status_pemesanan = 'Confirmed', updated_at = CURRENT_TIMESTAMP WHERE referenceId = '".$invoiceId."'";

if ($conn->query($sql) === TRUE) {
    // Log jika update berhasil
} else {
    $teks = "Error updating transaction status: " . $conn->error;
    $myfile = fopen("error.txt", "a") or die("Unable to open file!");
    fwrite($myfile, $teks . "\n");
    fclose($myfile);
}

// Menutup koneksi database
$conn->close();

// Log data pembayaran
$myfile = fopen("payment.txt", "a") or die("Unable to open file!");
fwrite($myfile, $data . "\n");
fclose($myfile);

?>
