<?php
session_start();
$curl = curl_init();

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
'message' => 'Terima Kasih!. Kami mengucapkan terima kasih atas kepercayaan Anda yang telah memesan di penginapan kami. Pembelian Anda telah berhasil dan sampai bertemu dilain waktu.
         Hormat kami,
        [Kost Ertiga Ngaliyan]', 
'countryCode' => '62', //optional
),
  CURLOPT_HTTPHEADER => array(
    'Authorization:5HsruFbKb_nfcx@c7nkh' //change TOKEN to your actual token
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

$myfile = fopen("status.txt", "a") or die("Unable to open file!");
fwrite($myfile, $response . "\n");
fclose($myfile);