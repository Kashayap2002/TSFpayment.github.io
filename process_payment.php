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
    $clientId = 'AdpH6mBHSNEtFYnK3BqrzwKUkhXXXbAzqkY2Jqd-KOPsGLwFxvpeiQQ7m7Dz3E1VLgBsXc9V9mzj3455';
    $clientSecret = 'ECtoX4xkf8Y4j4pMFZEhcGAWsMsPpnJKc28sG64H_rSCeIAWO8Dz5ABlRPkRQeuIA5_pU_5ibEBmFpsg';
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
                
                $invoice = "Invoice: Amount - $" . $amount;

               
                $to = $email;
                $subject = "Payment Confirmation";
                $message = "Thank you for your donation. Invoice details: \n\n" . $invoice;
                $headers = "From: 21052466@kiit.ac.in";

                
                mail($to, $subject, $message, $headers);

               
                header("Location: thank.you.php?invoice=" . urlencode($invoice));
                exit();
            } else {
              
                echo "Order capture failed. Error details: " . $captureResponse->result;
            }
        } else {
           
            echo "Order creation failed. Error details: " . $response->result;
        }
    } catch (Exception $ex) {
        
        echo "An exception occurred. Error details: " . $ex->getMessage();
    }
}
?>
