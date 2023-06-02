<?php
// Retrieve the raw POST data from Midtrans
$request_body = file_get_contents('php://input');

// Verify the signature from Midtrans
$midtrans_signature = isset($_SERVER['HTTP_X_CALLBACK_SIGNATURE']) ? $_SERVER['HTTP_X_CALLBACK_SIGNATURE'] : '';
$server_key = 'YOUR_MIDTRANS_SERVER_KEY'; // Replace with your Midtrans server key
$is_signature_valid = verifySignature($request_body, $midtrans_signature, $server_key);

if ($is_signature_valid) {
    // Signature is valid, process the notification
    // Insert your notification processing logic here
    // You can access the data in $request_body and process accordingly
    
    // For example, you can decode the JSON data in the request body
    $notification_data = json_decode($request_body, true);
    
    // Extract the relevant information from the notification data
    $transaction_id = $notification_data['transaction_id'];
    $transaction_status = $notification_data['transaction_status'];
    
    // Perform necessary actions based on the transaction status
    if ($transaction_status === 'capture') {
        // Transaction is successfully captured, update your database or perform other actions
        // ...
    } elseif ($transaction_status === 'settlement') {
        // Transaction is successfully settled, update your database or perform other actions
        // ...
    } elseif ($transaction_status === 'cancel' || $transaction_status === 'deny' || $transaction_status === 'expire') {
        // Transaction is cancelled, denied, or expired, update your database or perform other actions
        // ...
    } elseif ($transaction_status === 'pending') {
        // Transaction is still pending, update your database or perform other actions
        // ...
    }
    
    // Send a response back to Midtrans to acknowledge receipt of the notification
    http_response_code(200);
    echo 'Notification received and processed.';
} else {
    // Signature is not valid, ignore the notification
    http_response_code(403);
    echo 'Invalid signature. Notification ignored.';
}

/**
 * Verify the signature from Midtrans.
 *
 * @param string $request_body The raw POST data from Midtrans
 * @param string $signature The signature from Midtrans
 * @param string $server_key Your Midtrans server key
 * @return bool True if the signature is valid, false otherwise
 */
function verifySignature($request_body, $signature, $server_key) {
    $expected_signature = hash('sha512', $server_key . $request_body);
    return hash_equals($expected_signature, $signature);
}
?>