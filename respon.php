<?php
include "token.php";
date_default_timezone_set('Asia/Jakarta');

// Menentukan waktu kedaluwarsa
$expireTime = date('Y-m-d\TH:i', strtotime('+3 hours'));

// Mengambil data dari POST
$name = $_POST['name'];
$nomorhandphone = $_POST['phone'];
$email = $_POST['email'];
$start_month = $_POST['start_month'];
$duration = intval($_POST['duration']);
$tipekamar = $_POST['room_type'];
$jumlahkamar = intval($_POST['room_count']);
$harga_per_malam = intval($_POST['harga_per_malam']);

// Validasi input
if (empty($name) || empty($nomorhandphone) || empty($email) || empty($start_month) || $duration <= 0 || $jumlahkamar <= 0 || $harga_per_malam <= 0) {
    die("Input tidak valid.");
}
// Hitung total harga
$total_harga = $harga_per_malam * $jumlahkamar * $duration;

// Tambahkan detail periode pemesanan
$remarks = "Bulan Mulai: $start_month\nDurasi: $duration bulan";

// Buat body untuk invoice
$bodyCreateInvoice = array(
    "invoiceName" => $name,
    "referenceId" => "YPD" . date("mdHis"),
    "userName" => $name,
    "userEmail" => $email,
    "userPhone" => $nomorhandphone,
    "remarks" => $remarks,
    "payAmount" => $total_harga,
    "expireTime" => $expireTime,
    "billMasterId" => $billMasterId,
    "paymentMethod" => array(
        "type" => "VA_CLOSED",
        "bankCode" => "022"
    ),
    "items" => array(
        array(
            "itemName" => $tipekamar,
            "itemType" => "ITEM",
            "itemCount" => $jumlahkamar,
            "itemTotalPrice" => $total_harga
        )
    )
);
// Signature untuk invoice
$pathInvoice = '/api/v1/invoice';
$urlCreateInvoice = $host . $pathInvoice;
$signRelativeURLCreateInvoice = parse_url($urlCreateInvoice, PHP_URL_PATH);
$rawBodyCreateInvoice = json_encode($bodyCreateInvoice);
$dataToSignCreateInvoice = $api_key . $signRelativeURLCreateInvoice . $rawBodyCreateInvoice;
$signatureCreateInvoice = hash_hmac('sha256', $dataToSignCreateInvoice, $api_secret);

$chCreateInvoice = curl_init($urlCreateInvoice);
$headersCreateInvoice = array(
    "Content-Type: application/json",
    "Authorization: Bearer " . $accessToken,
    "x-aiyo-key: " . $api_key,
    "x-aiyo-signature: " . $signatureCreateInvoice
);

curl_setopt($chCreateInvoice, CURLOPT_TIMEOUT, 30);
curl_setopt($chCreateInvoice, CURLOPT_POST, 1);
curl_setopt($chCreateInvoice, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($chCreateInvoice, CURLOPT_HTTPHEADER, $headersCreateInvoice);
curl_setopt($chCreateInvoice, CURLOPT_POSTFIELDS, $rawBodyCreateInvoice);

$responseCreateInvoice = curl_exec($chCreateInvoice);
$invoice = json_decode($responseCreateInvoice);

if ($invoice && $invoice->responseCode == '2000000') {
    $invoiceId = $invoice->responseData->invoiceId;
    $accessToken = $invoice->responseData->accessToken;

    include "koneksi.php";
    $sql = "INSERT INTO transaksi (referenceId, userName, userEmail, userPhone, remarks, payAmount, 
            items, invoiceId, status, timestamp) VALUES (
                '".$bodyCreateInvoice['referenceId']."', 
                '".$bodyCreateInvoice['userName']."', 
                '".$bodyCreateInvoice['userEmail']."', 
                '".$bodyCreateInvoice['userPhone']."', 
                '".str_replace(array('\'', '"', ',', ';', '<', '>', '/'), ' ', $bodyCreateInvoice['remarks'])."', 
                '".$bodyCreateInvoice['payAmount']."', 
                '".json_encode($bodyCreateInvoice['items'])."', 
                '".$invoiceId."', 
                'NEW', 
                current_timestamp()
            )";

        if ($conn->query($sql) === TRUE) {
            // Mengirim pesan konfirmasi
            $message = "Halo, $name,\n\n"
                        . "Pemesanan Anda berhasil dengan rincian:\n"
                        . "Tipe Kamar: $tipekamar\nJumlah Kamar: $jumlahkamar\nDurasi: $duration bulan\n"
                        . "Total Bayar: Rp " . number_format($total_harga, 0, ',', '.') . "\n\n"
                        . "Terima kasih telah memesan di Wisma Purbadanarta.";
    
            // Integrasi dengan Fonnte
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://api.fonnte.com/send',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => array(
                    'target' => $nomorhandphone,
                    'message' => $message,
                    'countryCode' => '62',
                ),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: 5HsruFbKb_nfcx@c7nkh'
                ),
            ));
    
            curl_exec($curl);
            curl_close($curl);
    
            echo "
            <html>
            <body>
                <h2>Invoice Berhasil Dibuat</h2>
                <p>Silakan cek status pembayaran Anda dengan <a href='cek.php?invoiceId=$invoiceId&accessToken=$accessToken'>link ini</a>.</p>
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