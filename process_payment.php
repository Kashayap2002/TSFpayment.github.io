<?php

require 'vendor/autoload.php'; // Include the PayPal SDK

use PayPalCheckoutSdk\Core\PayPalHttpClient;
use PayPalCheckoutSdk\Core\SandboxEnvironment;
use PayPalCheckoutSdk\Orders\OrdersCreateRequest;
use PayPalCheckoutSdk\Orders\OrdersCaptureRequest;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $amount = $_POST['amount'];
    $paymentType = $_POST['paymentType'];
    $email = $_POST['email'];

    // Set up PayPal API credentials
    $clientId = 'AZO64UyG4iF3Lgav0MYPTkBW-9ZZXrGC8xARQvVF';
    $clientSecret = 'EGuPIWBVa6SwCRDMFmXkG6GO4V5ahZx77JkVzSWe';
    $environment = new SandboxEnvironment($clientId, $clientSecret);
    $client = new PayPalHttpClient($environment);

    try {
        // Create a new order
        $request = new OrdersCreateRequest();
        $request->prefer('return=representation');
        $request->body = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $amount
                    ]
                ]
            ]
        ];

        $response = $client->execute($request);

        if ($response->statusCode == 201) {
            // Order created successfully, capture the order
            $orderId = $response->result->id;

            // Capture the order
            $captureRequest = new OrdersCaptureRequest($orderId);
            $captureResponse = $client->execute($captureRequest);

            if ($captureResponse->statusCode == 201) {
                // Order captured successfully

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
            } else {
                // Order capture failed, handle the error
                echo "Order capture failed. Error details: " . $captureResponse->result;
            }
        } else {
            // Order creation failed, handle the error
            echo "Order creation failed. Error details: " . $response->result;
        }
    } catch (Exception $ex) {
        // Exception occurred, handle the error
        echo "An exception occurred. Error details: " . $ex->getMessage();
    }
}
?>
