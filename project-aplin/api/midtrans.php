<?php
use Midtrans\Midtrans\Client;
Midtrans\Config::$serverKey = 'SB-Mid-server-mbi4j9oO7P0a_dFf5ZrwiUlb';
Midtrans\Config::$isProduction = false;
Midtrans\Config::$isSanitized = true;
Midtrans\Config::$is3ds = true;

class Midtrans {

    public static $merchantId = 'G392079047';
    public static $clientKey = 'SB-Mid-client-NXfEHbGR3uU6xLRP';
    public static $serverKey = 'SB-Mid-server-mbi4j9oO7P0a_dFf5ZrwiUlb';
    public static $apiEndpoint = 'https://app.sandbox.midtrans.com/snap/v1/transactions';

    public static function getClientKey()
    {
        return self::$clientKey;
    }

    public static function getSnapToken($amount, $id) {
        $user = Users::getFromId($id);
        $params = array(
            'transaction_details' => array(
                'order_id' => rand(),
                'gross_amount' => $amount,
            ),
            'customer_details' => array(
                'username' => $user['name'],
                'email' =>  $user['email']
            ),
            'finish' => base_path() . ' /payment_handling.php',
        );
        
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        return $snapToken;
    }


}
