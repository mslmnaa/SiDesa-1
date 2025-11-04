<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\MidtransService;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $midtransService;

    public function __construct(MidtransService $midtransService)
    {
        $this->midtransService = $midtransService;
    }

    /**
     * Show payment page with Midtrans Snap
     */
    public function show(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            abort(403, 'Anda tidak memiliki akses ke order ini');
        }

        // Jika order sudah dibayar, redirect ke detail order
        if ($order->payment_status === 'paid') {
            return redirect()->route('user.orders.show', $order)
                ->with('info', 'Order ini sudah dibayar');
        }

        // Jika belum ada snap token, generate
        if (!$order->midtrans_snap_token) {
            try {
                $snapToken = $this->midtransService->createTransaction($order);
                $order->update([
                    'midtrans_snap_token' => $snapToken,
                    'midtrans_order_id' => $order->order_number,
                ]);
            } catch (\Exception $e) {
                return redirect()->route('user.orders.show', $order)
                    ->with('error', 'Gagal membuat pembayaran: ' . $e->getMessage());
            }
        }

        return view('user.payment.show', compact('order'));
    }

    /**
     * Handle payment notification from Midtrans (Webhook)
     */
    public function notification(Request $request)
    {
        try {
            $notification = $this->midtransService->handleNotification();

            // Find order by order number
            $order = Order::where('order_number', $notification['order_number'])->first();

            if (!$order) {
                return response()->json(['message' => 'Order not found'], 404);
            }

            // Update order payment status
            $order->update([
                'midtrans_transaction_id' => $notification['transaction_id'],
                'midtrans_transaction_status' => $notification['transaction_status'],
                'payment_status' => $notification['payment_status'],
                'paid_at' => $notification['payment_status'] === 'paid' ? now() : null,
            ]);

            // Update order status based on payment status
            if ($notification['payment_status'] === 'paid') {
                $order->update([
                    'status' => 'processing', // Set to processing, not completed
                ]);
            } elseif (in_array($notification['payment_status'], ['failed', 'expired', 'cancelled'])) {
                $order->update(['status' => 'cancelled']);
            }

            return response()->json(['message' => 'Notification handled successfully']);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error handling notification',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Handle finish redirect from Midtrans
     */
    public function finish(Request $request)
    {
        $orderNumber = $request->order_id;
        $order = Order::where('order_number', $orderNumber)->first();

        if (!$order) {
            return redirect()->route('user.orders.index')
                ->with('error', 'Order tidak ditemukan');
        }

        // Check transaction status dari Midtrans
        try {
            $status = $this->midtransService->getTransactionStatus($orderNumber);

            $transactionStatus = $status->transaction_status;
            $paymentStatus = 'pending';

            if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                $paymentStatus = 'paid';
            } elseif ($transactionStatus == 'pending') {
                $paymentStatus = 'pending';
            } elseif (in_array($transactionStatus, ['deny', 'expire', 'cancel'])) {
                $paymentStatus = 'failed';
            }

            // Update order
            $order->update([
                'midtrans_transaction_id' => $status->transaction_id ?? null,
                'midtrans_transaction_status' => $transactionStatus,
                'payment_status' => $paymentStatus,
                'paid_at' => $paymentStatus === 'paid' ? now() : null,
            ]);

            if ($paymentStatus === 'paid') {
                $order->update([
                    'status' => 'processing', // Set to processing, not completed
                ]);
            }

        } catch (\Exception $e) {
            // Jika error, tetap redirect ke order detail
        }

        return redirect()->route('user.orders.show', $order)
            ->with('success', 'Terima kasih! Status pembayaran Anda sedang diproses.');
    }

    /**
     * Check payment status
     */
    public function checkStatus(Order $order)
    {
        // Pastikan order milik user yang login
        if ($order->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $status = $this->midtransService->getTransactionStatus($order->order_number);

            return response()->json([
                'success' => true,
                'transaction_status' => $status->transaction_status,
                'payment_status' => $order->payment_status,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
