<?php

namespace Sadegh\Payment\Gateways\Zarinpal;

use Illuminate\Http\Request;
use Sadegh\Payment\Contracts\GatewayContract;
use Sadegh\Payment\Models\Payment;
use Sadegh\Payment\Repositories\PaymentRepo;

class ZarinpalAdaptor implements GatewayContract
{
    private $url;
    private $client;
    public function request( $amount , $description)
    {
         $this->client = new zarinpal();
         $callback = route("payments.callback");
         $result =  $this->client->request("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx", $amount, $description ,"","",$callback,true);
        if (isset($result["Status"]) && $result["Status"] == 100)
        {
            $this->url = $result['StartPay'];
            return $result['Authority'];
        } else {
            return [
                "status" => $result["Status"],
                "message" => $result["Message"]
            ];
        }


    }

    public function verify(Payment $payment)
    {

       $this->client = new zarinpal();
       $result =   $this->client->verify("xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx",$payment->amount,true);

        if (isset($result["Status"]) && $result["Status"] == 100)
        {
            return  $result["RefID"];
        } else {
            return [
                'status' => $result["Status"],
                'message' => $result["Message"]
            ];
        }

    }

    public function redirect()
    {
      $this->client->redirect($this->url);
    }

    public function getName()
    {
       return 'zarinpal';
    }
    public function getInvoiceIdFromRequest(Request $request)
    {
        return $request->Authority;
    }
}
