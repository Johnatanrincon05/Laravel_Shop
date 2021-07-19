<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Dnetix\Redirection\Contracts\Gateway;
use Dnetix\Redirection\PlacetoPay;
use App\Models\Order;
use App\Models\Transaction;

class PaymentController extends Controller
{

    public function result($reference)
    {

        echo $reference;
    }

    public function create($id)
    {

        //Validar si se tienen transacciones para la orden.

        //Validar si alguna de dichas transacciones aun no tiene estado.

        //Preguntar primero a placetopay si en verdad no tiene estado.

        //Si no tiene estado entonces generar un nuevo pago con una nueva transaccion, si si tiene reutilizar el mismo.

        //1. Obtener info de la tx

        $order = Order::find($id);

        $transactions = Transaction::where('order_id', '=', $id)->count();

        if ($transactions > 0) {

            //Consult if the process url is available else 

        } else {

            $resultrequest = $this->generateRequest($order);

            if ($resultrequest["request_done"] > 0) {
                
                //Save tx PENDING   

                // $transaction = Transaction::create($request->all());
                
            }else{
                
                
                
            }
            

        }
    }

    public function generateRequest($order)
    {
        $placetopay = new PlacetoPay([
            'login' => '6dd490faf9cb87a9862245da41170ff2',
            'tranKey' => '024h1IlD',
            'url' => 'https://dev.placetopay.com/redirection/',
            'rest' => [
                'timeout' => 45, // (optional) 15 by default
                'connect_timeout' => 30, // (optional) 5 by default
            ]
        ]);

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
            'returnUrl' => 'http://localhost:8000/payment/result?reference=' . $reference,
            'ipAddress' => '127.0.0.1',
            'userAgent' => 'Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2743.116 Safari/537.36',
        ];

        try {

            $response = $placetopay->request($request);

            $info_return= array();

            if (!is_null($response->requestId) && !is_null($response->processUrl) && $response->requestId != '' && $response->processUrl != '') {
                // Redirect the client to the processUrl or display it on the JS extension
                
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
            
            $info_return["log"] = json_encode($response);
            $info_return["url"] = "not_available";
            $info_return["requestId"] = "not_available";
            $info_return["request_done"] = 0; 

        }

        $info_return["reference"] = $reference;

        return $info_return;

    }
}
