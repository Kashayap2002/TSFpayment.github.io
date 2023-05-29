<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Payment Page</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Payment Page</h1>

    <form action="process_payment.php" method="POST">
        <div class="form-group">
            <label for="amount">Amount:</label>
            <input type="number" id="amount" name="amount" required>
        </div>

        <div class="form-group">
            <label for="paymentType">Payment Type:</label>
            <select id="paymentType" name="paymentType" required>
                <option value="">Select Payment Type</option>
                <option value="creditcard">Credit Card</option>
                <option value="paypal">PayPal</option>
                
            </select>
        </div>

        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <input type="submit" value="Pay Now">
        </div>
    </form>
</body>
</html>
