<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $paymentType = $_POST['paymentType'];
    $email = $_POST['email'];

    // Process the payment based on the selected payment type
    // You would need to integrate with the respective payment gateway API here

    // Generate the invoice
    $invoice = "Invoice: Amount - $" . $amount;

    // Send email with the invoice
    $to = $email;
    $subject = "Payment Confirmation";
    $message = "Thank you for your donation. Invoice details: \n\n" . $invoice;
    $headers = "From: 21052466@kiit.ac.in";

    // Uncomment the line below to send the email (requires a configured email service provider)
    // mail($to, $subject, $message, $headers);

    // Redirect to the thank you page
    header("Location: thankyou.html");
    exit();
}

?>
