<?php
include "aiyo_config.php";
$pathInvoice = '/api/v1/invoice';
$invoiceId = $_GET['invoiceId'];
$accessToken = $_GET['accessToken'];
$URLCekStatus = $host . $pathInvoice . "/" . $invoiceId . "?accessToken=" . $accessToken;

$chCekInvoice = curl_init($URLCekStatus);
curl_setopt($chCekInvoice, CURLOPT_TIMEOUT, 30);
curl_setopt($chCekInvoice, CURLOPT_RETURNTRANSFER, TRUE);
$responseCekInvoice = curl_exec($chCekInvoice);
$cekInvoice = json_decode($responseCekInvoice);
$status = $cekInvoice->responseData->invoiceStatus;
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cek Status Pembayaran - Kost Ertiga Ngaliyan</title>
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-image: url('gambar/background.jpg'); /* Ganti dengan gambar latar belakang yang sesuai */
      background-size: cover;
      background-position: center;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: #333;
    }

    .container {
      max-width: 800px;
      background-color: rgba(255, 255, 255, 0.9);
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
      padding: 40px;
      margin: 20px;
      border-radius: 10px;
    }

    h1, p {
      color: #333;
    }

    h1 {
      font-size: 28px;
      margin-bottom: 20px;
      text-align: center;
    }

    p {
      font-size: 18px;
      margin-bottom: 15px;
    }

    a {
      color: #fff;
      text-decoration: none;
      padding: 10px 20px;
      background-color: #4CAF50;
      border-radius: 5px;
      display: inline-block;
      margin-top: 20px;
    }

    a:hover {
      background-color: #45a049;
    }

    .button-container {
      display: flex;
      justify-content: center;
      align-items: center;
      margin-top: 20px;
    }

    .button {
      background-color: #007BFF;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      text-decoration: none;
      font-size: 16px;
      transition: background-color 0.3s ease;
    }

    .button:hover {
      background-color: #0056b3;
    }

    .success-message {
      background-color: #d4edda;
      color: #155724;
      padding: 15px;
      border-left: 5px solid #28a745;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .new-invoice {
      background-color: #f8d7da;
      color: #721c24;
      padding: 15px;
      border-left: 5px solid #dc3545;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    /* Nama tambahan Kost Ertiga Ngaliyan */
    .header {
      text-align: center;
      margin-bottom: 30px;
    }

    .header h2 {
      font-size: 24px;
      color: #555;
    }
  </style>
</head>
<body>
<div class="container">
  <div class="header">
    <h2>Kost Ertiga Ngaliyan</h2> <!-- Nama ditampilkan di bagian atas -->
  </div>
<?php
if ($status == "NEW") {
    echo "<div class='new-invoice'>";
    echo "<h1>Invoice Baru</h1>";
    echo "<p>Invoice: " . $cekInvoice->responseData->invoicename . "</p>";
    echo "<p>Senilai: Rp" . number_format($cekInvoice->responseData->total_harga, 0, ',', '.') . "</p>";
    echo "<p>Status: " . $status . "</p>";
    echo "</div>";
    echo "<div class='button-container'><a href='" . $cekInvoice->responseData->invoiceURL . "' target='_blank' class='button'>Lanjutkan pembayaran</a></div>";
} else if ($status == "PAID") {
    echo "<div class='success-message'>";
    echo "<h1>Pembayaran Berhasil</h1>";
    echo "<p>Terima kasih, pembayaran Anda telah berhasil.</p>";
    echo "</div>";
} else {
    echo "<div class='new-invoice'>";
    echo "<h1>Status: $status</h1>";
    echo "<p>Silakan periksa kembali informasi Anda atau hubungi customer service.</p>";
    echo "</div>";
}
?>
</div>
</body>
</html>
