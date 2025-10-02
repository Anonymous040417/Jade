
<?php

/*Call function with these configurations*/
$env = "sandbox";
$shortcode = '174379';
$type = '4';
$key = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919"; // Put your key here
$secret = "Jo3JaIlTsEHsu13rs0JGR4flzfafP3GYifWfffwBFZ80GcWXogaIlmSSMpb6slN3";  // Put your secret here
$initiatorName = "testapi";
$initiatorPassword = "Safaricom999!*!";
$results_url = "https://mfc.ke/callback.php"; // Endpoint to receive results Body
$timeout_url = "https://mfc.ke/callback.php"; // Endpoint to go to on timeout
/*End configurations*/

// Ensure the transaction ID is set
$transactionID = "QCS2FC258A"; // For testing purposes
$command = "TransactionStatusQuery";
$remarks = "Transaction Status Query";
$occasion = "Transaction Status Query";
$callback = null;

if (isset($_POST['phone_number'])) {
    // Step 1: Generate Access Token
    $access_token_url = ($env == "live") ? "https://api.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials" : "https://sandbox.safaricom.co.ke/oauth/v1/generate?grant_type=client_credentials";
    $credentials = base64_encode($key . ':' . $secret);

    $ch = curl_init($access_token_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ["Authorization: Basic " . $credentials]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    
    if (curl_errno($ch)) {
        echo 'Error in Access Token request: ' . curl_error($ch);
        exit();
    }

    if ($response === false) {
        echo "Error: Unable to connect to Safaricom's API.";
        exit();
    }

    // Debugging: Log the raw response to see if it's valid JSON
    echo "Raw response from Safaricom (Access Token Request): " . $response . "<br>";

    $result = json_decode($response);

    // Debugging: Log if the JSON decoding failed
    if ($result === null) {
        echo "Error: Invalid JSON response received. Check the raw response for more details.<br>";
        exit();
    }

    if (isset($result->access_token)) {
        $token = $result->access_token;
    } else {
        echo 'Failed to obtain access token: ' . (isset($result->errorMessage) ? $result->errorMessage : "Unknown error");
        exit();
    }

    // Step 2: Encrypt the Initiator Password using the public certificate
    $publicKeyPath = __DIR__ . "/mpesa_public_cert.cer";
    
    if (!file_exists($publicKeyPath)) {
        echo 'Public certificate file not found. Ensure mpesa_public_cert.cer is present.';
        exit();
    }

    $publicKey = file_get_contents($publicKeyPath);

    if (!openssl_public_encrypt($initiatorPassword, $encrypted, $publicKey, OPENSSL_PKCS1_PADDING)) {
        echo 'Error encrypting the password using the public certificate.';
        exit();
    }

    $password = base64_encode($encrypted);

    // Step 3: Prepare data for transaction status query
    $curl_post_data = [
        "Initiator" => $initiatorName,
        "SecurityCredential" => $password,
        "CommandID" => $command,
        "TransactionID" => $transactionID,
        "PartyA" => $shortcode,
        "IdentifierType" => $type,
        "ResultURL" => $results_url,
        "QueueTimeOutURL" => $timeout_url,
        "Remarks" => $remarks,
        "Occasion" => $occasion
    ];

    $data_string = json_encode($curl_post_data);

    // Step 4: Send the transaction status query
    $endpoint = ($env == "live") ? "https://api.safaricom.co.ke/mpesa/transactionstatus/v1/query" : "https://sandbox.safaricom.co.ke/mpesa/transactionstatus/v1/query";

    $ch2 = curl_init($endpoint);
    curl_setopt($ch2, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $token,
        'Content-Type: application/json'
    ]);
    curl_setopt($ch2, CURLOPT_POST, 1);
    curl_setopt($ch2, CURLOPT_POSTFIELDS, $data_string);
    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch2);

    if (curl_errno($ch2)) {
        echo 'Error in Transaction Status Query request: ' . curl_error($ch2);
        exit();
    }
    curl_close($ch2);

    echo "Response: " . $response;

    // Step 5: Handle the API response
    $result = json_decode($response);

    if (isset($result->ResponseCode)) {
        $verified = $result->ResponseCode;
        if ($verified === "0") {
            echo "Transaction Verification request Sent SUCCESSFULLY";
        } else {
            echo "Verification Request UNSUCCESSFUL";
        }
    } else {
        echo "Error: " . (isset($result->errorMessage) ? $result->errorMessage : "Unknown error");
    }
}

