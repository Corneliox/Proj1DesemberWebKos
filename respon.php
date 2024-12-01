<?php
// Konfigurasi awal
include "token.php";
date_default_timezone_set('Asia/Jakarta');
require_once 'resources/views/template.php';

// Menentukan waktu kedaluwarsa invoice
$expireTime = date('Y-m-d\TH:i', strtotime('+3 hours'));

// Mengambil data dari POST request
$name = $_POST['name'];
$nomorhandphone = $_POST['phone'];
$email = $_POST['email'];
$start_month = $_POST['start_month'];
$duration = intval($_POST['duration']);
$tipekamar = $_POST['room_type'];
$harga_per_bulan = intval($_POST['harga_per_malam']);
$jumlahkamar = intval($_POST['room_count']);

// Validasi input
if (empty($name) || empty($nomorhandphone) || empty($email) || 
    empty($start_month) || $duration <= 0 || $jumlahkamar <= 0 || $harga_per_bulan <= 0) {
    die("Input tidak valid.");
}

// Hitung total harga
$total_harga = $harga_per_bulan * $jumlahkamar * $duration;

// Menyiapkan deskripsi pemesanan
$remarks = "Bulan Mulai: $start_month\nDurasi: $duration bulan";

// Buat body request API invoice
$bodyCreateInvoice = [
    "invoiceName" => $name,
    "referenceId" => "YPD" . date("mdHis"),
    "userName" => $name,
    "userEmail" => $email,
    "userPhone" => $nomorhandphone,
    "remarks" => $remarks,
    "payAmount" => $total_harga,
    "expireTime" => $expireTime,
    "billMasterId" => $billMasterId,
    "paymentMethod" => [
        "type" => "VA_CLOSED",
        "bankCode" => "022"
    ],
    "items" => [
        [
            "itemName" => $tipekamar,
            "itemType" => "ITEM",
            "itemCount" => $jumlahkamar,
            "itemTotalPrice" => $total_harga
        ]
    ]
];

// Signature untuk API
$pathInvoice = '/api/v1/invoice';
$urlCreateInvoice = $host . $pathInvoice;
$signRelativeURLCreateInvoice = parse_url($urlCreateInvoice, PHP_URL_PATH);
$rawBodyCreateInvoice = json_encode($bodyCreateInvoice);
$dataToSignCreateInvoice = $api_key . $signRelativeURLCreateInvoice . $rawBodyCreateInvoice;
$signatureCreateInvoice = hash_hmac('sha256', $dataToSignCreateInvoice, $api_secret);

// Request cURL untuk membuat invoice
$chCreateInvoice = curl_init($urlCreateInvoice);
$headersCreateInvoice = [
    "Content-Type: application/json",
    "Authorization: Bearer " . $accessToken,
    "x-aiyo-key: " . $api_key,
    "x-aiyo-signature: " . $signatureCreateInvoice
];

curl_setopt_array($chCreateInvoice, [
    CURLOPT_TIMEOUT => 30,
    CURLOPT_POST => 1,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => $headersCreateInvoice,
    CURLOPT_POSTFIELDS => $rawBodyCreateInvoice,
]);

$responseCreateInvoice = curl_exec($chCreateInvoice);
$invoice = json_decode($responseCreateInvoice);

// Proses respons API
if ($invoice && $invoice->responseCode == '2000000') {
    $invoiceId = $invoice->responseData->invoiceId;
    $accessToken = $invoice->responseData->accessToken;

    // Simpan data transaksi ke database
    include "koneksi.php";
    $sql = "INSERT INTO transaksi (
        referenceId, userName, userEmail, tipe_kamar, jumlah_kamar, 
        durasi_bulan, total_harga, status_pemesanan
        ) VALUES (
            '".$bodyCreateInvoice['referenceId']."', 
            '".$bodyCreateInvoice['userName']."', 
            '".$bodyCreateInvoice['userEmail']."', 
            '".$bodyCreateInvoice['items'][0]['itemName']."', 
            '".$bodyCreateInvoice['items'][0]['itemCount']."', 
            '$duration', 
            '$total_harga', 
            'NEW'
        )";

    if ($conn->query($sql) === TRUE) {
        // Kirim notifikasi WhatsApp menggunakan Fonnte
        $message = "Halo $name,\n\n"
            . "Terima kasih telah mempercayakan kami untuk kebutuhan akomodasi Anda.\n"
            . "Rincian Pemesanan:\n\n"
            . "*Tipe Kamar*: $tipekamar\n"
            . "*Jumlah Kamar*: $jumlahkamar\n"
            . "*Durasi*: $duration bulan\n"
            . "*Total Bayar*: Rp " . number_format($total_harga, 0, ',', '.') . "\n\n"
            . "Jika ada pertanyaan, hubungi kami di *082242227643*.\n\n"
            . "Salam hangat,\n*KOST ERTIGA NGALIYAN*.";

        $curl = curl_init();
        curl_setopt_array($curl, [
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'target' => $nomorhandphone,
                'message' => $message,
                'countryCode' => '62',
            ],
            CURLOPT_HTTPHEADER => [
                'Authorization: 5HsruFbKb_nfcx@c7nkh'
            ],
        ]);
        curl_exec($curl);
        curl_close($curl);

        // Tampilkan halaman sukses
        echo "<!DOCTYPE html>
        <html lang='id'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Invoice Berhasil Dibuat</title>
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background-color: #f9f9f9;
                    color: #333;
                    margin: 0;
                    padding: 20px;
                }
                .container {
                    max-width: 600px;
                    margin: 50px auto;
                    background: #fff;
                    padding: 20px;
                    border-radius: 8px;
                    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                .container h2 {
                    color: #012970;
                }
                .container p {
                    line-height: 1.6;
                }
                .button {
                    display: inline-block;
                    margin-top: 20px;
                    padding: 10px 20px;
                    font-size: 16px;
                    color: #fff;
                    background-color: #4154f1;
                    text-decoration: none;
                    border-radius: 5px;
                }
                .button:hover {
                    background-color: #45a049;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Invoice Berhasil Dibuat</h2>
                <p>Hai, <strong>$name</strong>, invoice Anda telah berhasil dibuat!</p>
                <p>Silakan cek status pembayaran dengan mengklik tautan di bawah ini:</p>
                <a href='cek.php?invoiceId=$invoiceId&accessToken=$accessToken' class='button'>Cek Status Pembayaran</a>
            </div>
        </body>
        </html>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
} else {
    echo "Error: " . $responseCreateInvoice;
}

curl_close($chCreateInvoice);
?>
