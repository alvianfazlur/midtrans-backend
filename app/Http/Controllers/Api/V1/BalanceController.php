<?php

namespace App\Http\Controllers\Api\V1;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Balance;

class BalanceController extends Controller
{
    public function setUser(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'uid' => 'required',
                'name' => 'required',
                'email' => 'required',
                'hobby' => 'required',
                'balance' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return response()->json(['message' => 'invalid', 'data' => $validator->errors()], 400); // Kode status 400 untuk Bad Request
            } else {
                $order = Balance::create([
                    'uid' => $request->uid,
                    'name' => $request->name,
                    'email' => $request->email,
                    'hobby' => $request->hobby,
                    'balance' => $request->balance,
                ]);

                return response()->json(['message' => 'success', 'data' => $order], 201); // Kode status 201 untuk Created
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'error', 'data' => $e->getMessage()], 500); // Kode status 500 untuk Internal Server Error
        }
    }

    public function getBalance(Request $request){
        try {
            $user_id = $request->user_id;
            $balance = Balance::where('uid', $user_id)->pluck('balance');
            return $balance;
        } catch (\Exception $e) {
            return response()->json(['message' => 'An error occurred'], 500);
        }
    }
}
