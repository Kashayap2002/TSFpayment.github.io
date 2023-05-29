<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $paymentType = $_POST['paymentType'];
    $email = $_POST['email'];

   
    $invoice = "Invoice: Amount - $" . $amount;

    
    $to = $email;
    $subject = "Payment Confirmation";
    $message = "Thank you for your donation. Invoice details: \n\n" . $invoice;
    $headers = "From: 21052466@kiit.ac.in";

    header("Location: thankyou.php");
    exit();
}

?>
