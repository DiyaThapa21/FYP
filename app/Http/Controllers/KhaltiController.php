<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Product;
use DB;



class KhaltiController extends Controller
{
    public function payment()
    {
        $cart = Cart::where('user_id', auth()->user()->id)->where('order_id', null)->get()->toArray();
        
        $data = [];
        
        $data['items'] = array_map(function ($item) {
            $name = Product::where('id', $item['product_id'])->pluck('title')->first();
            return [
                'name' => $name,
                'price' => $item['price'],
                'desc' => 'Thank you for using Khalti',
                'qty' => $item['quantity']
            ];
        }, $cart);

        $data['invoice_id'] = 'ORD-' . strtoupper(uniqid());
        $data['invoice_description'] = "Order #{$data['invoice_id']} Invoice";
        $data['return_url'] = route('payment.success');
        $data['cancel_url'] = route('payment.cancel');

        $total = 0;
        foreach ($data['items'] as $item) {
            $total += $item['price'] * $item['qty'];
        }

        $data['total'] = $total;
        if (session('coupon')) {
            $data['shipping_discount'] = session('coupon')['value'];
        }
        Cart::where('user_id', auth()->user()->id)->where('order_id', null)->update(['order_id' => session()->get('id')]);

        $token = $this->initiateKhaltiPayment($data['total']);

        if ($token) {
            return view('khalti.payment', compact('token', 'data'));
        } else {
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }

    private function initiateKhaltiPayment($amount)
    {
        // Implement Khalti payment initiation logic here to get a token
        // This is just a placeholder
        return 'khalti_token';
    }

    public function cancel()
    {
        return redirect()->route('home')->with('error', 'Your payment is canceled.');
    }

    public function verifyPayment(Request $request)
    {
        
        $token = $request->token;
        $itemId = $request->itemId;
    
    
        $args = http_build_query([
            'token' => $token,
            'amount' => 1000
    
        ]);
     
    
       
        $url = "https://khalti.com/api/v2/payment/verify/";
    
       
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $args);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    
      
        $secret_key = config('app.khalti_secret_key');
        $headers = ["Authorization: Key $secret_key"];
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    
      
        $response = curl_exec($ch);
        $status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
       
        return $response;
    }
    
    public function storePayment(Request $request)
    {
    
        
   
        return response()->noContent();
    }

    

}