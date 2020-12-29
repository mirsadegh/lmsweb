<?php
namespace Sadegh\Payment\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sadegh\Payment\Gateways\Gateway;
use Sadegh\Payment\Models\Payment;
use Sadegh\Payment\Repositories\PaymentRepo;

class Paymentcontroller extends Controller
{
    public function callback(Request $request)
    {
        $gateway = resolve(Gateway::class);
        $paymentRepo = new PaymentRepo();
        $payment = $paymentRepo->findByInvoiceId($gateway->getInvoiceIdFromRequest($request));

        if(!$payment){
            newFeedback("تراکنش ناموفق","تراکنش مورد نظر یافت نشد!","error");
            return redirect('/');
        }

        $result = $gateway->verify($payment);

        if (is_array($result)){
            newFeedback("عملیات ناموفق",$result["message"],"error");
            $paymentRepo->changeStatus($payment->id,Payment::STATUS_FAIL);
            return redirect()->to($payment->paymentable->path());

        }

        newFeedback("عملیات موفق","پرداخت با موفقیت انجام شد.","success");
        $paymentRepo->changeStatus($payment->id,Payment::STATUS_SUCCESS);
        return redirect('/');

    }


}
