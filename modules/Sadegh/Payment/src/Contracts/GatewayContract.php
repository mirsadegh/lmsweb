<?php

namespace Sadegh\Payment\Contracts;


use Sadegh\Payment\Models\Payment;


interface GatewayContract{


    public function request($amount , $description);

    public function verify(Payment $payment);

    public function redirect();

    public function getName();

}
