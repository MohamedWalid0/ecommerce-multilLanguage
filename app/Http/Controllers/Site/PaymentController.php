<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use App\Events\NewOrder;
use App\Models\Order;
use App\Models\Transaction;
use GuzzleHttp\Client;


class PaymentController extends Controller
{
    
    private $base_url;
    private $request_client;
    private $token;


    public function fatoorah(){
        $token = 'PCS55Fkp0XGUXLIKUnoxrJzPomxgJeV8jWkA9daf7_9lLjmotDCkEreHruxiLKLV58NgvQ5CnH45zyPYUX4ptPOuw_vkKgC53FJOwtxUSDzxO8WTBS0jnsoesOU5r_tpqrmEXWTxy3zeUIHA2xLrd4kWwk7NgwGmocJF004Yt3Vs-Ja4EjdAqvyZBBUAdtQWhJcXJRFRrSkLh4p04YYFbYW6S_EVU3XYuPdVl5Jdu7Jnl4GuJX-gS20xMt8qWaBJywQv5rmUZEopghb-3f-AXHQyAVotnYqR2vFYLm_JY76-jNcB_FgGqIAiPwNJFjqWpKIule2Q0PNK-MH72tyYIIGtPsSNlaxLc8p8LHiEQgASVeYGiCsQP-uTP3IGa8bCPD6Mmw-JwehFz7JEwV7lm0CM67iblPQewNq5eZ0kxGOHTp3ghs7KIAHpuJJRz1rAM591A4TOo0pxGRP-d4Q_Sz1JSzhfxfbGGYkVcyaHGtzMRI4rvjclPQi6H0Y7GkOK9-LizFvwT8ifWnS63fJhZLgUvHwOjTKqAMUmvt2BAkWRmpzUkAVfpLbiKFBjZRdEkbOMJURqjW6Nvu95qKfkVk5uo2dA4yxUFj6IdgDGlj3lrjmL1bMKDT7JP107-QyxfFtLssBGfcsSbiP12QkiUGu3G2DasNqOSE0KCbp4kRHwdizE' ;
        $baseURL = 'https://apitest.myfatoorah.com';

        $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => "$baseURL/v2/ExecutePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"PaymentMethodId\":\"2\",\"CustomerName\": \"Ahmed\",\"DisplayCurrencyIso\": \"KWD\", \"MobileCountryCode\":\"+965\",\"CustomerMobile\": \"92249038\",\"CustomerEmail\": \"aramadan@myfatoorah.com\",\"InvoiceValue\": 100,\"CallBackUrl\": \"https://google.com\",\"ErrorUrl\": \"https://google.com\",\"Language\": \"en\",\"CustomerReference\" :\"ref 1\",\"CustomerCivilId\":12345678,\"UserDefinedField\": \"Custom field\",\"ExpireDate\": \"\",\"CustomerAddress\" :{\"Block\":\"\",\"Street\":\"\",\"HouseBuildingNo\":\"\",\"Address\":\"\",\"AddressInstructions\":\"\"},\"InvoiceItems\": [{\"ItemName\": \"Product 01\",\"Quantity\": 1,\"UnitPrice\": 100}]}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);
            if ($err) {
                return  "cURL Error #:" . $err;
            } else {
            return response() -> json($response);

            }

            $json  = json_decode((string)$response, true);
            //echo "json  json: $json '<br />'";

            $payment_url = $json["Data"]["PaymentURL"];

                # after getting the payment url call it as a post API and pass card info to it
                # if you saved the card info before you can pass the token for the api

            $curl = curl_init();
            curl_setopt_array($curl, array(
            CURLOPT_URL => "$payment_url",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"paymentType\": \"card\",\"card\": {\"Number\":\"5123450000000008\",\"expiryMonth\":\"05\",\"expiryYear\":\"21\",\"securityCode\":\"100\"},\"saveToken\": false}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token","Content-Type: application/json"),
            ));
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            $response2 = curl_exec($curl);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
            return  "cURL Error #:" . $err;
            } else {
            // return 'dfdfdf';
            return response() -> json($response2);
            }

    }

    public function __construct(Client $request_client)
    {
        $this->request_client = $request_client;
        $this->base_url = env('MYFATOORAHBASEURL');
        $this->token = env('MYFATOORAHTOKEN');

    }

    public function getPayments($amount)
    {
        return view('front.cart.payments', compact('amount'));
    }

    /**
     * @param Request $request
     */
    public function processPayment(Request $request)
    {
        $token = 'PCS55Fkp0XGUXLIKUnoxrJzPomxgJeV8jWkA9daf7_9lLjmotDCkEreHruxiLKLV58NgvQ5CnH45zyPYUX4ptPOuw_vkKgC53FJOwtxUSDzxO8WTBS0jnsoesOU5r_tpqrmEXWTxy3zeUIHA2xLrd4kWwk7NgwGmocJF004Yt3Vs-Ja4EjdAqvyZBBUAdtQWhJcXJRFRrSkLh4p04YYFbYW6S_EVU3XYuPdVl5Jdu7Jnl4GuJX-gS20xMt8qWaBJywQv5rmUZEopghb-3f-AXHQyAVotnYqR2vFYLm_JY76-jNcB_FgGqIAiPwNJFjqWpKIule2Q0PNK-MH72tyYIIGtPsSNlaxLc8p8LHiEQgASVeYGiCsQP-uTP3IGa8bCPD6Mmw-JwehFz7JEwV7lm0CM67iblPQewNq5eZ0kxGOHTp3ghs7KIAHpuJJRz1rAM591A4TOo0pxGRP-d4Q_Sz1JSzhfxfbGGYkVcyaHGtzMRI4rvjclPQi6H0Y7GkOK9-LizFvwT8ifWnS63fJhZLgUvHwOjTKqAMUmvt2BAkWRmpzUkAVfpLbiKFBjZRdEkbOMJURqjW6Nvu95qKfkVk5uo2dA4yxUFj6IdgDGlj3lrjmL1bMKDT7JP107-QyxfFtLssBGfcsSbiP12QkiUGu3G2DasNqOSE0KCbp4kRHwdizE' ;
        $baseURL = 'https://apitest.myfatoorah.com';
    
        $error = '';

        //best practice as we do sperate validation on request form file
        $validator = Validator::make($request->all(), [
            'ccNum' => 'required',
            'ccExp' => 'required',
            'ccCvv' => 'required|numeric',
            'amount' => 'required|numeric|min:100',
        ]);

        if ($validator->fails()) {
            $error = 'Please check if you have filled in the form correctly. Minimum order amount is PHP 100.';
        }

        $ccNum = str_replace(' ', '', $request->ccNum);
        $ccExp = $request->ccExp;
        $ccCvv = $request->ccCvv;
        $amount = $request->amount;
        $customerName = auth()->user()->name;
        $customerEmail = 'demo@gmail.com';
        $phone = substr(auth()->user()->mobile, 4);
        $ccExp = explode('/', $ccExp);
        $ccMon = $ccExp[0];
        $ccYear = $ccExp[1];
        $customerMobile = strlen($phone) <= 11 ? $phone : '123456';
        $data['Language'] = 'en';
        $PaymentMethodId = $request->PaymentMethodId;
        // $token = $this->token;
        // $baseURL = $this->base_url;
        // dd($ccCvv) ;
        $curl = curl_init();
        // dd($curl) ;



        // you can use laravel http or Guzzl and you my create an object to encode that oject direct on request
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$baseURL/v2/ExecutePayment",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"PaymentMethodId\":\"$PaymentMethodId\",\"CustomerName\": \"$customerName\",\"DisplayCurrencyIso\": \"SAR\", \"MobileCountryCode\":\"+965\",\"CustomerMobile\": \"$customerMobile\",\"CustomerEmail\": \"$customerEmail\",\"InvoiceValue\": $amount,\"CallBackUrl\": \"https://dieera.com\",\"ErrorUrl\": \"https://dieera.com\",\"Language\": \"en\",\"CustomerReference\" :\"ref 1\",\"CustomerCivilId\":12345678,\"UserDefinedField\": \"Custom field\",\"ExpireDate\": \"\",\"CustomerAddress\" :{\"Block\":\"\",\"Street\":\"\",\"HouseBuildingNo\":\"\",\"Address\":\"\",\"AddressInstructions\":\"\"},\"InvoiceItems\": []}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($curl);
        // echo $response ;
        // dd($response) ;

        $err = curl_error($curl);
        curl_close($curl);
        
        if ($err) {
            return [
                'payment_success' => false,
                'status' => 'faild',
                'error' => $err
            ];
        }

        $json = json_decode((string)$response, true);
        // return $json ;
        // echo "json  json: $json '<br />'";

        $payment_url = $json["Data"]["PaymentURL"];


        $card = new \stdClass();
        $card->Number = $ccNum;
        $card->expiryMonth = trim($ccMon);
        $card->expiryYear = trim($ccYear);
        $card->securityCode = trim($ccCvv);
        $card_data = json_encode($card);

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => "$payment_url",
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => "{\"paymentType\": \"card\",\"card\":$card_data,\"saveToken\": false}",
            CURLOPT_HTTPHEADER => array("Authorization: Bearer $token", "Content-Type: application/json"),
        ));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return [
                'paymemt_success' => false,
                'status' => 'faild',
                'error' => $err
            ];
        }

        $json = json_decode((string)$response, true);
        $PaymentId = $json["Data"]["PaymentId"];
        try {
            DB::beginTransaction();
            // if success payment save order and send realtime notification to admin
            $order = $this->saveOrder($amount, $PaymentMethodId);  // your task is  . add products with options to order to preview on admin
            $this->saveTransaction($order, $PaymentId);
            DB::commit();

            //fire event on order complete success for realtime notification
            event(new NewOrder($order));

        } catch (\Exception $ex) {
            DB::rollBack();
            return $ex;
        }
        // replace return statment with message that tell the user that the payment successes
        return [
            'payment_success' => true,
            'token' => $PaymentId,
            'data' => $json,
            'status' => 'succeeded',
        ];
    }

    private function saveOrder($amount, $PaymentMethodId)
    {
        return Order::create([
            'customer_id' => auth()->id(),
            'customer_phone' => auth()->user()->mobile,
            'customer_name' => auth()->user()->name,
            'total' => $amount,
            'locale' => 'en',
            'payment_method' => $PaymentMethodId,  // you can use enumeration here as we use before for best practices for constants.
            'status' => Order::PAID,
        ]);

    }

    private function saveTransaction(Order $order, $PaymentId)
    {
        Transaction::create([
            'order_id' => $order->id,
            'transaction_id' => $PaymentId,
            'payment_method' => $order->payment_method,
        ]);
    }





}
