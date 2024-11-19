<?php
include "token.php";
date_default_timezone_set('Asia/Jakarta');

// Menentukan waktu kedaluwarsa
$expireTime = date('Y-m-d\TH:i', strtotime('+3 hours'));

// Mengambil data dari POST
$name = $_POST['name'];
$nomorhandphone = $_POST['phone']; // Pastikan ini sesuai dengan form
$email = $_POST['email'];
$tipekamar = $_POST['room_type']; // Pastikan ini sesuai dengan form
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$jumlahkamar = $_POST['room_count']; // Pastikan ini sesuai dengan form
$harga_per_malam = $_POST['harga_per_malam'];

// Menghitung total hari menginap
$checkinDate = new DateTime($checkin);
$checkoutDate = new DateTime($checkout);
$interval = $checkinDate->diff($checkoutDate);
$totalDays = $interval->days;

// Tentukan nilai 'payAmount' dan 'tipekamar' berdasarkan input kamar
switch ($tipekamar) {
    case 'Ekonomi':
        $payAmount = $harga_per_malam * $jumlahkamar * $totalDays; // Mengoreksi angka menjadi 100000
        $tipekamar = "Kamar Ekonomi";
        break;
    case 'Standart':
        $payAmount = $harga_per_malam * $jumlahkamar * $totalDays;
        $tipekamar = "Kamar Standart";
        break;
    case 'Deluxe':
        $payAmount = $harga_per_malam * $jumlahkamar * $totalDays;
        $tipekamar = "Kamar Deluxe";
        break;
    default:
        $payAmount = 0;
        $tipekamar = "Tidak Diketahui";
        break;
}

// Menambahkan detail check-in dan check-out ke dalam catatan
$remarks = "Check-in: " . $checkinDate->format('Y-m-d') . "\n"
         . "Check-out: " . $checkoutDate->format('Y-m-d');

$bodyCreateInvoice = array(
    "invoiceName" => $name,
    "referenceId" => "YPD" . date("mdHis"),
    "userName" => $name,
    "userEmail" => $email,
    "userPhone" => $nomorhandphone,
    "remarks" => $remarks, // Menggunakan isi remarks yang sudah ditentukan
    "payAmount" => $payAmount,
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
            "itemCount" => "1",
            "itemTotalPrice" => $payAmount
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
        // Mengirim pesan menggunakan Fonnte API
        $curl = curl_init();

        // Membuat pesan dengan rincian pemesanan
        $message = "Halo, $name,\n\n"
                 . "Terima kasih telah mempercayakan kami untuk kebutuhan akomodasi Anda. "
                 . "Pemesanan kamar Anda telah berhasil kami terima dengan rincian sebagai berikut:\n\n"
                 . "Tipe Kamar: $tipekamar\n"
                 . "Jumlah Kamar: $jumlahkamar\n"
				 . "Total Bayar: Rp $payAmount\n"
                 . "Check-in: " . $checkinDate->format('Y-m-d') . "\n"
                 . "Check-out: " . $checkoutDate->format('Y-m-d') . "\n\n"
                 . "Kami sangat menantikan kedatangan Anda dan akan berusaha memberikan pelayanan terbaik selama Anda menginap.\n\n"
                 . "Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami di 082242227643.\n\n"
                 . "Salam hangat,\nWISMA PURBADANARTA.";

        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api.fonnte.com/send',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS => array(
                'target' => $nomorhandphone,
                'message' => $message,
                'countryCode' => '62', // Kode negara untuk Indonesia
            ),
            CURLOPT_HTTPHEADER => array(
                'Authorization: 5HsruFbKb_nfcx@c7nkh' // Ganti TOKEN dengan token Fonnte kamu
            ),
        ));

        $response = curl_exec($curl);
        if (curl_errno($curl)) {
            $error_msg = curl_error($curl);
        }
        curl_close($curl);

        if (isset($error_msg)) {
            echo $error_msg;
        }

        // Simpan respons dari Fonnte ke file status.txt
        $myfile = fopen("status.txt", "a") or die("Unable to open file!");
        fwrite($myfile, $response . "\n");
        fclose($myfile);

        // Menampilkan pesan sukses kepada pengguna
        $linkCek = "cek.php?invoiceId=" . urlencode($invoiceId) . "&accessToken=" . urlencode($accessToken);
        echo "
        <!DOCTYPE html>
        <html lang='en'>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Invoice Berhasil</title>
            <style>
                body {
                    margin: 0;
                    padding: 0;
                    height: 100vh;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    background-image: url('gambar/background.jpg'); /* Ganti dengan gambar yang sesuai */
                    background-size: cover;
                    background-position: center;
                }
                .container {
                    max-width: 600px;
                    width: 100%;
                    padding: 20px;
                    background-color: rgba(255, 255, 255, 0.9);
                    border-radius: 10px;
                    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                    text-align: center;
                }
                h2 {
                    color: #2c3e50;
                }
                p {
                    color: #7f8c8d;
                }
                .btn {
                    background-color: #3498db;
                    color: white;
                    border: none;
                    padding: 12px 24px;
                    border-radius: 5px;
                    font-size: 16px;
                    cursor: pointer;
                    text-decoration: none;
                }
                .btn:hover {
                    background-color: #2980b9;
                }
            </style>
        </head>
        <body>
            <div class='container'>
                <h2>Invoice Berhasil Dibuat</h2>
                <p>Terima kasih telah memesan di Wisma Purbadanarta. Silakan cek status pembayaran Anda dengan mengklik tombol di bawah ini.</p>
                <a href='" . $linkCek . "' class='btn'>Lanjutkan</a>
            </div>
        </body>
        </html>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    // Tutup koneksi
    $conn->close();
} else {
    echo "Error: " . $responseCreateInvoice; // Tampilkan error dari pembuatan invoice
}

curl_close($chCreateInvoice);
?>
