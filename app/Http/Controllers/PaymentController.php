<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dnetix\Redirection\Contracts\Gateway;
use Dnetix\Redirection\PlacetoPay;
use App\Models\Order;
use App\Models\Transaction;
use Monolog\Handler\IFTTTHandler;

class PaymentController extends Controller
{

    public function result($reference)
    {

        $info_result = $this->validateState($reference);

        if ($info_result["result_query"] > 0) {

            if ($info_result["state"] != 'PENDING') {
                
                $this->updateOrder($reference, $info_result["state"]);

                return redirect()->route('orders.show', $info_result["order_id"]);

            }else{

                return redirect()->route('orders.index');
                
            }

        }

    }

    public function updateOrder($reference, $state){

        $Transaction = Transaction::where("reference_code",$reference)->first();

        $Order = Order::find($Transaction->Order->id);

        if ($state == "APPROVED" || $state == "APPROVED_PARTIAL") {

            $Order->status = "PAYED";
    
            $Order->save();

        }else if($state == "REJECTED" || $state == "PARTIAL_EXPIRED"){

            $Order->status = "REJECTED";
    
            $Order->save();

        }

        if ($state == "APPROVED" || $state == "APPROVED_PARTIAL" || $state == "REJECTED" || $state == "PARTIAL_EXPIRED") {
            
            $Transaction->status = $state;
    
            $Transaction->save();

        }

    }

    public function loginGategay(){

        $placetopay = new PlacetoPay([
            'login' => config('services.placetopay.login_placetopay'),
            'tranKey' => config('services.placetopay.trankey_placetopay'),
            'url' => config('services.placetopay.url_placetopay'),
            'rest' => [
                'timeout' => 45, // (optional) 15 by default
                'connect_timeout' => 30, // (optional) 5 by default
            ]
        ]);

        return $placetopay;

    }

    public function validateState($reference){

        $placetopay = $this->loginGategay();

        $transactions_count = Transaction::where('reference_code', '=', $reference)->count();

        $result = array("result_query"=>0,"state"=>"not_available","url"=>"none","order_id"=>0);

        if ($transactions_count > 0) {
            
            $info_transaction = Transaction::where('reference_code',$reference)->first();
            
            $result["url"] = $info_transaction->processing_url;
            
            $result["order_id"] = $info_transaction->order_id;

            try {

            $response = $placetopay->query($info_transaction->session_identifier);

            $result["state"] = $response->status()->status();
            
            $result["result_query"] = 1;

            } catch (Exception $e) {

                $result["state"] = "not_available";
            
                $result["result_query"] = 0;

            }

        }

        return $result;

    }

    public function create($id)
    {

        $order = Order::find($id);

        $transactions_count = Transaction::where('order_id', '=', $id)->where('status', '=', 'PENDING')->count();

        $success_payment_request = 0;

        if ($order->status != 'PAYED') {
            
            if ($transactions_count > 0) {
                
                $info_transaction = Transaction::where('order_id',$id)->where('status', '=', 'PENDING')->orderBy('created_at', 'desc')->get()->first();

                $result_state_validation = $this->validateState($info_transaction->reference_code);

                if ($result_state_validation["state"] == "PENDING") {
                    
                    header("Location: ".$info_transaction->processing_url);
                    die();

                }else{

                    $this->result($info_transaction->reference_code);

                    
                }

            } else {
    
                $resultrequest = $this->generateRequest($order);

                if ($resultrequest["request_done"] > 0) {
    
                    $transaction = new Transaction;
    
                    $transaction->order_id = $id;
                    $transaction->reference_code = $resultrequest["reference"];
                    $transaction->session_identifier = $resultrequest["requestId"];
                    $transaction->processing_url = $resultrequest["url"];
                    $transaction->status = 'PENDING';
    
                    $saved = $transaction->save();
    
                    if($saved){
    
                        $success_payment_request = 1;
    
                    }
    
                }
    
            }

        }

        if ($success_payment_request == 1 && $transactions_count == 0) {
    
            header('Location: '.$resultrequest["url"]);
            die();
            
        }else{

            return redirect()->route('orders.show',$order->id)->with('danger', 'We have had a problem, please try again. If the problem persists, please contact technical support.');

        }

    }

    public function generateRequest($order)
    {

        $placetopay = $this->loginGategay();

        $reference = uniqid();

        $request = [
            'locale' => 'es_CO',
            "payer" => [
                "document" => $order->customer_identification,
                "documentType" => $order->customer_identification_type,
                "name" => $order->customer_name,
                "surname" => "AJ",
                "email" => $order->customer_email,
                "mobile" => $order->customer_mobile
            ],
            'payment' => [
                'reference' => $reference,
                'description' => $order->product,
                'amount' => [
                    'currency' => 'COP',
                    'total' => $order->total,
                ],
            ],
            'expiration' => date('c', strtotime('+2 days')),
            'returnUrl' => 'http://localhost:8000/payment/result/' . $reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        try {

            $response = $placetopay->request($request);

            $info_return= array();

            if (!is_null($response->requestId) && !is_null($response->processUrl) && $response->requestId != '' && $response->processUrl != '') {
                
                $info_return["log"] = json_encode($response);
                $info_return["url"] = $response->processUrl;
                $info_return["requestId"] = $response->requestId;
                $info_return["request_done"] = 1; 

            } else {

                $info_return["log"] = json_encode($response);
                $info_return["url"] = "not_available";
                $info_return["requestId"] = "not_available";
                $info_return["request_done"] = 0; 

            } 

        } catch (Exception $e) {

            $info_return["log"] = "FAILED";
            $info_return["url"] = "not_available";
            $info_return["requestId"] = "not_available";
            $info_return["request_done"] = 0; 

        }

        $info_return["reference"] = $reference;

        return $info_return;

    }
}
