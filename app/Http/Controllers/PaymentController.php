<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TicketPurchased;
use Illuminate\Support\Facades\Http;


class PaymentController extends Controller
{
    public function paymentStart(Request $request)
    {
        $totalamt=$request->input('totalprice');
        $quantity=$request->input('quantity');
        $user_id=auth()->guard('user')->user()->id;
        $event_id=$request->input('id');
        $pid = uniqid();
        $payment=new TicketPurchased();

        $payment->total=$totalamt;
        $payment->quantity=$quantity;
        $payment->transaction_id=$pid;
        $payment->payment_method="Esewa";
        $payment->user_id=$user_id;
        $payment->event_id=$event_id;
        $payment->save();
        return $this->redirectToEsewa($pid,$totalamt);
    } 
    private function generateSignature($data, $secretKey) {
        $signatureData = "";
        $signedFieldNames = explode(',', $data['signed_field_names']);
        
        foreach ($signedFieldNames as $field) {
            $signatureData .= $field . '=' . $data[$field] . ',';
        }
        
        $signatureData = rtrim($signatureData, ',');
        return base64_encode(hash_hmac('sha256', $signatureData, $secretKey, true));
    }

    public function redirectToEsewa($pid,$totalamt) {
        $amount =$totalamt;
        $pid = $pid;
        $merchantCode = env('ESEWA_MERCHANT_CODE');
        $secretKey = env('ESEWA_SECRET_KEY'); 

        $data = [
            'amount' => $amount,
            'tax_amount' => 0,
            'product_delivery_charge' => 0,
            'product_service_charge' => 0,
            'total_amount' => $amount,
            'transaction_uuid' => $pid,
            'product_code' => $merchantCode,
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
            'success_url' => route('esewa.success'),
            'failure_url' => route('esewa.failure'),
        ];

        $data['signature'] = $this->generateSignature($data, $secretKey);

        return view('esewa', compact('data'));
    }
    public function verifyPayment(Request $request)
    {
        $secretKey = env('ESEWA_SECRET_KEY');
        $merchantCode = env('ESEWA_MERCHANT_CODE');
    
        // Step 1: Decode the 'data' from base64 and JSON
        $decodedData = json_decode(base64_decode($request->data), true);
    
        if (!$decodedData) {
            return "❌ Invalid data received.";
        }
    
        // Step 2: Extract required fields
        $totalAmount = str_replace(',', '', $decodedData['total_amount']);
        $transactionUuid = $decodedData['transaction_uuid'];
        $productCode = $decodedData['product_code'];
    
        // Step 3: Prepare for signature
        $verificationData = [
            'total_amount' => $totalAmount,
            'transaction_uuid' => $transactionUuid,
            'product_code' => $productCode,
            'signed_field_names' => 'total_amount,transaction_uuid,product_code',
        ];
    
        $verificationData['signature'] = $this->generateSignature($verificationData, $secretKey);
    
        // Step 4: Build query
        $query = http_build_query([
            'total_amount' => $totalAmount,
            'transaction_uuid' => $transactionUuid,
            'product_code' => $productCode,
            'signature' => $verificationData['signature']
        ]);
    
        $url = env('ESEWA_VERIFY_URL') . '?' . $query;
    
        // Step 5: Send request
        $response = Http::get($url);
    
        if (str_contains($response->body(), 'COMPLETE')) {
            $payment = TicketPurchased::where('transaction_id', $transactionUuid)->first();
            if ($payment) {
                $payment->payment_status = 'paid'; // Assuming you have a 'payment_status' column
                $payment->save();
            }
            return redirect()->back()->with('success',"Payment Success ful");
            
        } else {
            return "❌ Verification failed. Response: " . $response->body();
        }
    }
    
    
    
    public function paymentfailure(Request $request)
    {
        return 'payment failed';
    }

}
