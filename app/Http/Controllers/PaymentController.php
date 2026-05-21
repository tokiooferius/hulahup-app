<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\PaymentDetail;
use App\Models\Order;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Show checkout page (review before payment)
     */
    public function checkout()
    {
        $checkout = session()->get('checkout');

        if (!$checkout) {
            return redirect('/cart')->with('error', 'Keranjang kosong');
        }

        return view('checkout', compact('checkout'));
    }

    /**
     * Process payment with Midtrans
     */
    public function process(Request $request)
    {
        $checkout = session()->get('checkout');

        if (!$checkout) {
            return redirect('/cart')->with('error', 'Session checkout expired');
        }

        $user = auth()->user();

        // Create payment record
        $payment = Payment::create([
            'user_id' => $user->id,
            'transaction_code' => 'TXN-' . time() . '-' . $user->id,
            'total_amount' => $checkout['grand_total'],
            'status' => 'pending',
            'payment_method' => $request->input('payment_method', 'midtrans'),
        ]);

        // Create payment details for each canteen
        foreach ($checkout['cart_by_canteen'] as $canteenId => $canteenData) {
            PaymentDetail::create([
                'payment_id' => $payment->id,
                'canteen_id' => $canteenId,
                'amount_for_canteen' => $canteenData['total'],
                'status' => 'pending',
            ]);

            // Create orders for each canteen
            Order::create([
                'user_id' => $user->id,
                'canteen_id' => $canteenId,
                'order_number' => Order::generateOrderNumber(),
                'items' => json_encode($canteenData['items']),
                'total_amount' => $canteenData['total'],
                'status' => 'pending',
            ]);
        }

        // TODO: Integrate with Midtrans
        // For now, return success response
        session()->forget('checkout');

        return redirect('/history')->with('success', 'Pembayaran sedang diproses');
    }

    /**
     * Handle Midtrans payment callback/webhook
     */
    public function webhook(Request $request)
    {
        // TODO: Implement Midtrans webhook handler
        // Verify payment status and update orders
        
        return response()->json(['status' => 'ok']);
    }

    /**
     * Get payment status
     */
    public function status($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        // Check if user owns this payment
        if ($payment->user_id !== auth()->id() && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return response()->json([
            'payment' => $payment,
            'details' => $payment->paymentDetails()->with('canteen')->get(),
        ]);
    }
}
