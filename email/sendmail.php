<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';

include "../koneksi.php";

// Mulai sesi dan dapatkan referenceId
session_start();

// Pastikan session referenceId sudah di-set
if (!isset($_SESSION['referenceId'])) {
    die("Reference ID tidak ditemukan di session.");
}

$referenceId = $_SESSION['referenceId'];

// Ambil data transaksi dari database berdasarkan referenceId
$sql = "SELECT * FROM transaksi WHERE referenceId = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $referenceId);
$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Kirim email
    $mail = new PHPMailer(true);

    try {
        // Pengaturan server email
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'purbadanartawisma@gmail.com';
        $mail->Password   = "nlcy yqao sikk wolc"; // Pastikan password SMTP benar
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // Penerima email
        $mail->setFrom('purbadanartawisma@gmail.com', 'Wisma Purba Danarta');
        $mail->addAddress($row['userEmail'], $row['userName']);
        $mail->addReplyTo('purbadanartawisma@gmail.com', 'Wisma Purba Danarta');
        $mail->addCC('rafif.arsya.pradiva@gmail.com');
        $mail->addBCC('rafif.arsya.pradiva@gmail.com');

        // Isi email
        $mail->isHTML(true);
        $mail->Subject = 'Konfirmasi Pemesanan Kamar Wisma Purba Danarta';
        $mail->Body    = '
            Terima kasih atas kepercayaan Anda telah melakukan pemesanan kamar di Wisma Purba Danarta.
            <br><br>
            Berikut adalah detail pemesanan Anda:<br>
            <strong>Nama:</strong> ' . htmlspecialchars($row['userName']) . '<br>
            <strong>Email:</strong> ' . htmlspecialchars($row['userEmail']) . '<br>
            <strong>Nomor Telepon:</strong> ' . htmlspecialchars($row['userPhone']) . '<br>
            <strong>Jumlah Pembayaran:</strong> Rp ' . number_format($row['payAmount'], 0, ',', '.') . ',-<br>
            <strong>Items:</strong> ' . htmlspecialchars($row['items']) . '<br>
            <strong>Nomor Referensi:</strong> ' . htmlspecialchars($referenceId) . '
            <br><br>
            Kami sangat menantikan kedatangan Anda di Wisma Purba Danarta. Jika Anda memiliki pertanyaan lebih lanjut, jangan ragu untuk menghubungi kami.
            <br><br>
            Hormat kami,<br>
            Wisma Purba Danarta';
        $mail->AltBody = 'Terima kasih atas pemesanan Anda di Wisma Purba Danarta. Nomor Referensi: ' . htmlspecialchars($referenceId);

        $mail->send();
        echo "Email berhasil dikirim.";
    } catch (Exception $e) {
        $errorMessage = "Pesan tidak bisa dikirim. Kesalahan Mailer: {$mail->ErrorInfo}";
        file_put_contents("email_error.txt", $errorMessage . PHP_EOL, FILE_APPEND);
    }
} else {
    echo "Error dalam query SQL atau data tidak ditemukan: " . $conn->error;
}

?>