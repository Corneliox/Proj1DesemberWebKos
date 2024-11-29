<?php
include "token.php"; // File token.php untuk token dan konfigurasi API key

date_default_timezone_set('Asia/Jakarta');
include 'koneksi.php'; // Pastikan koneksi ke database sudah tersedia

// Ambil data dari form dengan metode POST
$referenceId = htmlspecialchars($_POST['referenceId']); // ID referensi transaksi
$name = htmlspecialchars($_POST['name']);
$email = htmlspecialchars($_POST['email']);
$nomorhandphone = htmlspecialchars($_POST['phone']);
$tipekamar = htmlspecialchars($_POST['room_type']);
$checkin = htmlspecialchars($_POST['checkin']);
$checkout = htmlspecialchars($_POST['checkout']);
$jumlahkamar = (int) $_POST['room_count']; // Pastikan jumlah kamar adalah angka

// Validasi apakah semua data wajib telah diisi
if (empty($referenceId) || empty($name) || empty($email) || empty($nomorhandphone) || empty($tipekamar) || empty($checkin) || empty($checkout) || empty($jumlahkamar)) {
    die("Semua data wajib diisi!");
}

// Query untuk mengambil data transaksi berdasarkan `referenceId`
$sql = "SELECT * FROM transaksi WHERE referenceId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $referenceId);
$stmt->execute();
$result = $stmt->get_result();

// Periksa apakah data ditemukan
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
} else {
    die("Data transaksi dengan Reference ID $referenceId tidak ditemukan.");
}

// Membuat pesan WhatsApp berdasarkan data dari database
$message = "Terima kasih, {$data['userName']}, telah mempercayakan kami untuk kebutuhan akomodasi Anda. "
         . "Pemesanan kamar Anda telah berhasil kami terima dengan rincian sebagai berikut:\n\n"
         . "Tipe Kamar: {$data['tipe_kamar']}\n"
         . "Jumlah Kamar: {$data['jumlah_kamar']}\n"
         . "Durasi Bulan: {$data['durasi_bulan']} bulan\n"
         . "Tanggal Mulai: {$data['tanggal_mulai']}\n"
         . "Tanggal Selesai: {$data['tanggal_selesai']}\n"
         . "Total Harga: Rp" . number_format($data['total_harga'], 2, ',', '.') . "\n\n"
         . "Kami sangat menantikan kedatangan Anda dan akan berusaha memberikan pelayanan terbaik selama Anda menginap.\n\n"
         . "Jika ada pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami di 082242227643.\n\n"
         . "Salam hangat,\nKost Ertiga Ngaliyan.";

// Bersihkan nomor telepon (menghapus karakter selain angka)
$nomorhandphone = preg_replace('/\D/', '', $data['userPhone']);

// Pastikan nomor telepon memiliki kode negara
if (substr($nomorhandphone, 0, 1) === "0") {
    $nomorhandphone = "62" . substr($nomorhandphone, 1);
}

// Inisialisasi cURL untuk mengirim pesan
$curl = curl_init();

// Mengatur opsi cURL untuk Fonnte API
curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fonnte.com/send',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'POST',
    CURLOPT_POSTFIELDS => array(
        'target' => $nomorhandphone,
        'message' => $message,
        'countryCode' => '62', // Kode negara untuk Indonesia
    ),
    CURLOPT_HTTPHEADER => array(
        'Authorization: 5HsruFbKb_nfcx@c7nkh', // Ganti dengan TOKEN API Fonnte Anda
    ),
));

// Eksekusi permintaan
$response = curl_exec($curl);
$error_msg = curl_errno($curl) ? curl_error($curl) : null;

curl_close($curl);

// Cek error dan log hasil
if ($error_msg) {
    // Simpan error ke file log
    $log_file = fopen("error_log.txt", "a") or die("Unable to open file!");
    fwrite($log_file, "[" . date("Y-m-d H:i:s") . "] Error: " . $error_msg . "\n");
    fclose($log_file);
    echo "Pengiriman pesan gagal: $error_msg";
} else {
    // Simpan respons API ke file log
    $log_file = fopen("status.txt", "a") or die("Unable to open file!");
    fwrite($log_file, "[" . date("Y-m-d H:i:s") . "] Response: " . $response . "\n");
    fclose($log_file);
    echo "Pesan berhasil dikirim!";
}
?>
