<?php
include('express-stk.php');
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $phone = $_POST['phone_number'];
    $amount = $_POST['payment_amount'];

    // Optional: Validate phone number and amount
    if (empty($phone) || empty($amount)) {
        $errmsg = "Phone number and amount are required.";
    } else {
        // Format phone number to Safaricom format if not already e.g. 2547xxxxxxx
        if (substr($phone, 0, 1) === '0') {
            $phone = '254' . substr($phone, 1);
        }

        // Call the stkPush function from express-stk.php
        $response = stkPush($phone, $amount);

        if ($response['ResponseCode'] == "0") {
            // STK push successful
            echo "<script>alert('STK Push sent successfully. Please check your phone to complete payment.');</script>";
        } else {
            $errmsg = "Failed to initiate payment: " . $response['errorMessage'];
        }
    }
}


// Retrieve the total price from the URL query string, if available
$price = isset($_GET['price']) ? $_GET['price'] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <style>
        /* Import fonts and basic styling */
        @import url(https://fonts.googleapis.com/css?family=Lato:400,100,300,700,900);
        @import url(https://fonts.googleapis.com/css?family=Source+Code+Pro:400,200,300,500,600,700,900);

        /* Basic styling for page layout */
        .container {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            flex-direction: column;
        }
        html {
            background-color: white;
            font-family: 'Lato', sans-serif;
        }
        .price h2 {
            font-weight: 300;
            color: black;
            letter-spacing: 2px; 
            text-align: center;
        }
        .card {
            margin-top: 30px;
            width: 520px;
        }
        .card .row {
            padding: 1rem 0;
            border-bottom: 1.2px solid black;
        }
        .card .row.amount .info label, .card .row.number .info label {
            color: black;
        }
        .cardholder .info, .number .info {
            margin-left: 40px;
        }
        #payment_amount {
            background-color: black;
            color: white;
            font-size: 20px;
        }
        .button button {
            font-size: 1.2rem;
            font-weight: 400;
            width: 100%;
            background-color: #18C2C0;
            color: #fff;
            padding: 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .button button:hover {
            background-color: #15aeac;
        }
        .footer {
            margin-top: 5rem;
            color: #8F92C3;
            text-align: center;
        }
    </style>
</head>
<body>
<div class="container">
    <form action='<?php echo $_SERVER['PHP_SELF'] ?>' method='POST'>
        <div class="price">
            <h2>Payment Terminal</h2>
        </div>
        <div class="card">
            <div class="row">
                <img src="mpesa.png" alt="MPESA Logo" style="width:30%; margin: 0 35%;">
                <p style="color:black; line-height:1.7;">
                    1. Enter the <b>Phone number and Amount</b> to pay and press "<b>Confirm and Pay</b>"<br>
                    2. You will receive a popup on your phone to enter your <b>MPESA PIN</b>.
                </p>
                <?php if (isset($errmsg) && $errmsg != ''): ?>
                    <p style="background: black; padding: .8rem; color: white;"><?php echo $errmsg; ?></p>
                <?php endif; ?>
            </div>
            <div class="row amount">
                <div class="info">
                    <label for="payment_amount">Amount</label>
                    <input id="payment_amount" type="number" name="payment_amount" placeholder="Enter amount" value="<?php echo htmlspecialchars($price); ?>" required />
                </div>
            </div>
            <div class="row number">
                <div class="info">
                    <label for="cardnumber">Phone number</label>
                    <input id="cardnumber" type="text" name="phone_number" maxlength="10" placeholder="0700000000" required />
                </div>
            </div>
        </div>
        <div class="button">
            <button type="submit"><i class="ion-locked"></i> Confirm and Pay</button>
        </div>
    </form>
    <p class="footer">&copy; 2025 | All Rights Reserved | Developer: Patrick</p>
</div>
</body>
</html>
