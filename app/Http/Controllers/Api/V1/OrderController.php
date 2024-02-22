<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Balance;

class OrderController extends Controller
{
    public function topup(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'name' => 'required',
            'total_topup' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['message' => 'invalid', 'data' => $validator->errors()]);
        }else{
            $order = Order::create([
                'id' => rand(),
                'user_id' => $request->user_id,
                'name' => $request->name,
                'total_topup' => $request->total_topup
            ]);

    
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = false;
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = array(
                'transaction_details' => array(
                    'order_id' => $order->id,
                    'gross_amount' => $order->total_topup,
                ),
                'customer_details' => array(
                    'first_name' => $order->name,
                ),
            );

            $snapToken = \Midtrans\Snap::getSnapToken($params);
          return $snapToken;
        }
    }
    
    public function callback(Request $request){
        $serverKey = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id.$request->status_code.$request->gross_amount.$serverKey);
        if($hashed == $request->signature_key){
            if($request->transaction_status == 'capture'){
                $order = Order::find($request->order_id);
                $order->update(['status' => 'Paid']);
            }
        }
    }

    public function getOrder(Request $request){
        try {
            $user_id = $request->user_id;
            $orders = Order::where('user_id', $user_id)->get();
    
            if ($orders->isEmpty()) {
                return response()->json(['message' => 'Orders not found'], 404);
            }
    
            return response()->json($orders, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
