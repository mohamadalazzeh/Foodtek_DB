<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{public function createOrder(Request $request)
    {
        try {
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'total_amount' => 'required|numeric',
                'status' => 'required|in:pending,preparing,out_for_delivery,completed,canceled',
                'payment_status' => 'required|in:pending,paid,failed',
            ]);
    
            DB::statement('CALL create_order(?, ?, ?, ?)', [
                $request->user_id,
                $request->total_amount,
                $request->status,
                $request->payment_status,
            ]);
    
            return response()->json(['message' => 'Order created successfully']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
}

