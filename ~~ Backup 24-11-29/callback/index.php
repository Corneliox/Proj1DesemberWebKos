<?php

session_start();

include "../koneksi.php";

$data = file_get_contents('php://input');

$data_decode = json_decode($data, true);

//var_dump($data_decode);

$invoiceId = $data_decode['invoiceId'];

$paymentAccountId = $data_decode['paymentAccountId'];

$paymentAccountType = $data_decode['paymentAccountType'];

$paymentAccountNumber = $data_decode['paymentAccountNumber'];

$paymentAccountName = $data_decode['paymentAccountName'];

$amount = $data_decode['amount'];

$status = $data_decode['status'];

$sql = "SELECT * FROM transaksi WHERE invoiceId = '".$invoiceId."'";

$result = $conn->query($sql);

if ($result) {

    $row = $result->fetch_assoc();

    $_SESSION['referenceId']=$row['referenceId'];

    $_SESSION['userName']=$row['userName'];

    $_SESSION['userEmail']=$row['userEmail'];

    $_SESSION['userPhone']=$row['userPhone'];

    $_SESSION['remarks']=$row['remarks'];

    $_SESSION['total_harga']=$row['total_harga'];

    $_SESSION['detail']=$row['items'];

} else {

    $teks = "Error updating status: " . $conn->error;

    $myfile = fopen("error.txt", "a") or die("Unable to open file!");

    fwrite($myfile, $teks . "\n");

    fclose($myfile);    

}

//require("../email/callback.php");


include "../email/sendmail.php";
include "../fonnte/index2.php";

$sql = "UPDATE transaksi SET status = 'PAID', timestamp = current_timestamp() WHERE invoiceId = '".$invoiceId."'";


if ($conn->query($sql) === TRUE) {

    //echo "Status updated successfully";

} else {

    $teks = "Error updating status: " . $conn->error;

    $myfile = fopen("error.txt", "a") or die("Unable to open file!");

    fwrite($myfile, $teks . "\n");

    fclose($myfile);    

}

$conn->close();

$myfile = fopen("payment.txt", "a") or die("Unable to open file!");

fwrite($myfile, $data . "\n");

fclose($myfile);

?>