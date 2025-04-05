<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // 🔹 إنشاء عملية دفع جديدة
    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'transaction_id' => 'nullable|string'
        ]);

        $payment = Payment::create([
            'order_id' => $request->order_id,
            'amount' => $request->amount,
            'payment_method' => $request->payment_method,
            'transaction_id' => $request->transaction_id,
            'status' => 'pending' // مبدئيًا، الحالة قيد الانتظار
        ]);

        return response()->json(['message' => 'Payment created', 'payment' => $payment]);
    }

    // 🔹 تحديث حالة الدفع (مثلاً عند تأكيد الدفع من بوابة الدفع)
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,refunded'
        ]);

        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        $payment->status = $request->status;
        $payment->save();

        return response()->json(['message' => 'Payment status updated', 'payment' => $payment]);
    }

    // 🔹 جلب جميع المدفوعات
    public function index()
    {
        return response()->json(Payment::all());
    }

    // 🔹 جلب مدفوعات طلب معين
    public function getByOrder($orderId)
    {
        $payments = Payment::where('order_id', $orderId)->get();

        if ($payments->isEmpty()) {
            return response()->json(['message' => 'No payments found for this order'], 404);
        }

        return response()->json($payments);
    }
}