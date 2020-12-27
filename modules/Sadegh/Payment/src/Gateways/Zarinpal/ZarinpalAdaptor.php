<?php

namespace Sadegh\Payment\Gateways\Zarinpal;

use Sadegh\Payment\Contracts\Gateway;
use Sadegh\Payment\Models\Payment;

class ZarinpalAdaptor implements Gateway
{

    public function request(Payment $payment)
    {
        $zp = new zarinpal();
        $callback = "";
         $result =  $zp->request("*****",$payment->amount,$payment->paymentable->title,"","",$callback);
        if (isset($result["Status"]) && $result["Status"] == 100)
        {
            return $result['Authority'];
            // Success and redirect to pay
//            $zp->redirect($result["StartPay"]);
        } else {
            // error
            echo "خطا در ایجاد تراکنش";
            echo "<br />کد خطا : ". $result["Status"];
            echo "<br />تفسیر و علت خطا : ". $result["Message"];
        }


    }

    public function verify(Payment $payment)
    {
        // TODO: Implement verify() method.
    }
}
