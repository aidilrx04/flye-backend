<?php

namespace App\Support\ToyyibPay;

use Carbon\Carbon;
use GuzzleHttp\Client;

class ToyyibPay
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function create_bill(
        string $billName,
        string $billDescription,
        float $billAmount,
        string $billReturnUrl,
        string $billCallbackUrl,
        mixed $billExternalReferenceNo,
        Carbon $billExpiryDate
    ): string {
        $client = new Client();

        $res = $client->post('https://dev.toyyibpay.com/index.php/api/createBill', [
            'form_params' => [
                'userSecretKey' => config('payment.payment.secret'),
                'categoryCode' => config('payment.payment.category'),
                'billName' => $billName,
                'billDescription' => $billDescription,
                'billPriceSetting' => 1,
                'billAmount' => $billAmount,
                'billPayorInfo' => 0,
                'billReturnUrl' => $billReturnUrl,
                'billCallbackUrl' => $billCallbackUrl,
                'billExternalReferenceNo' => $billExternalReferenceNo,
                'billExpiryDate' => $billExpiryDate->format('d-m-Y H:i:s'),
            ]
        ]);

        $body = (string)$res->getBody();
        $parsed = json_decode($body, 1);

        $bill_code = $parsed[0]['BillCode'];

        return $bill_code;
    }
}
