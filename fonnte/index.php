<?php
include "token.php"; // Pastikan token.php ada untuk mendapatkan $accessToken dan $api_key

date_default_timezone_set('Asia/Jakarta');

// Mengambil data dari POST (ganti sesuai dengan nama input dari form)
$name = $_POST['name'];
$nomorhandphone = $_POST['phone'];
$email = $_POST['email'];
$tipekamar = $_POST['room_type'];
$checkin = $_POST['checkin'];
$checkout = $_POST['checkout'];
$jumlahkamar = $_POST['room_count'];

// Membuat pesan dengan rincian pemesanan
$message = "Terima kasih, $name, telah mempercayakan kami untuk kebutuhan akomodasi Anda. "
         . "Pemesanan kamar Anda telah berhasil kami terima dengan rincian sebagai berikut:\n\n"
         . "Tipe Kamar: $tipekamar\n"
         . "Jumlah Kamar: $jumlahkamar\n"
         . "Check-in: $checkin\n"
         . "Check-out: $checkout\n\n"
         . "Kami sangat menantikan kedatangan Anda dan akan berusaha memberikan pelayanan terbaik selama Anda menginap.\n\n"
         . "Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami di 082242227643.\n\n"
         . "Salam hangat,\nWISMA PURBADANARTA.";

// Inisialisasi cURL untuk mengirim pesan
$curl = curl_init();

// Mengatur opsi cURL
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
    'target' =>  $_SESSION['userPhone'],
    'message' => $message,
    'countryCode' => '62', // Kode negara untuk Indonesia
  ),
  CURLOPT_HTTPHEADER => array(
    'Authorization: 5HsruFbKb_nfcx@c7nkh' // Ganti TOKEN dengan token Fonnte kamu
  ),
));

// Eksekusi permintaan
$response = curl_exec($curl);
if (curl_errno($curl)) {
  $error_msg = curl_error($curl);
}
curl_close($curl);

// Cek error dan simpan respon ke file
if (isset($error_msg)) {
  echo $error_msg;
} else {
  // Simpan respons ke file status.txt
  $myfile = fopen("status.txt", "a") or die("Unable to open file!");
  fwrite($myfile, $response . "\n");
  fclose($myfile);
}

// Kode pemesanan lainnya jika diperlukan bisa ditambahkan di sini

?>
