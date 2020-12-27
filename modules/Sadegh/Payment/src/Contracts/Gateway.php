<?php

namespace Sadegh\Payment\Contracts;

use Sadegh\Payment\Models\Payment;

interface Gateway{


    public function request(Payment $payment);

    public function verify(Payment $payment);

}
