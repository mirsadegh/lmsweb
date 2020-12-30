<?php
namespace Sadegh\Payment\Http\Controllers;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Sadegh\Payment\Events\PaymentWasSuccessful;
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


        }else{
            newFeedback("عملیات موفق","پرداخت با موفقیت انجام شد.","success");
            $paymentRepo->changeStatus($payment->id,Payment::STATUS_SUCCESS);
        }

        return redirect()->to($payment->paymentable->path());
    }

    public function callbackpay(Request $request)
    {

         $paymentRepo = resolve(PaymentRepo::class);
         $payment = $paymentRepo->findByInvoiceId($request->clientrefid);


        if(!$payment){
            newFeedback("تراکنش ناموفق","تراکنش مورد نظر یافت نشد!","error");
            return redirect('/');
        }


        $token = "fd7557b8571aad9827624e257c9504a2bcc15dce323db9dec841a7627bcdc0e5";

        $payping = new \PayPing\Payment($token);
        try {
            if($payping->verify($request->refid , 100)){
                event(new PaymentWasSuccessful($payment));
                newFeedback("عملیات موفق","پرداخت با موفقیت انجام شد.","success");
                $paymentRepo->changeStatus($payment->id,Payment::STATUS_SUCCESS);
            }else{
                newFeedback("عملیات ناموفق","پرداخت با موفقیت انجام نشد.","error");
                $paymentRepo->changeStatus($payment->id,Payment::STATUS_FAIL);
            }
        }
        catch (\PayPingException $e) {
            foreach (json_decode($e->getMessage(), true) as $msg) {
                echo $msg;
            }
        }

        return redirect()->to($payment->paymentable->path());
    }


}
