<?php

namespace App\Services;

use Midtrans\Config;
use Midtrans\Snap;
use Midtrans\Transaction;
use Midtrans\Notification;

class MidtransService
{
    public function __construct()
    {
        // Set Midtrans configuration
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$clientKey = config('services.midtrans.client_key');
        Config::$isProduction = config('services.midtrans.is_production');
        Config::$isSanitized = config('services.midtrans.is_sanitized');
        Config::$is3ds = config('services.midtrans.is_3ds');
    }

    /**
     * Create Snap payment token
     *
     * @param \App\Models\Order $order
     * @return string Snap token
     */
    public function createTransaction($order)
    {
        // Load relationships
        $order->load(['user', 'items.product', 'shippingAddress']);

        // Prepare item details
        $itemDetails = [];

        foreach ($order->items as $item) {
            $itemDetails[] = [
                'id' => $item->product_id,
                'price' => (int) $item->price,
                'quantity' => $item->quantity,
                'name' => $item->product_name,
            ];
        }

        // Add shipping cost as item
        if ($order->shipping_cost > 0) {
            $itemDetails[] = [
                'id' => 'SHIPPING',
                'price' => (int) $order->shipping_cost,
                'quantity' => 1,
                'name' => 'Biaya Pengiriman - ' . $order->shipping_service,
            ];
        }

        // Customer details
        $customerDetails = [
            'first_name' => $order->shippingAddress->recipient_name ?? $order->user->name,
            'email' => $order->user->email,
            'phone' => $order->shippingAddress->phone ?? $order->user->phone ?? '',
        ];

        // Shipping address
        if ($order->shippingAddress) {
            $customerDetails['shipping_address'] = [
                'first_name' => $order->shippingAddress->recipient_name,
                'phone' => $order->shippingAddress->phone,
                'address' => $order->shippingAddress->full_address,
                'city' => $order->shippingAddress->city_name,
                'postal_code' => $order->shippingAddress->postal_code,
                'country_code' => 'IDN',
            ];
        }

        // Transaction details
        $transactionDetails = [
            'order_id' => $order->order_number,
            'gross_amount' => (int) $order->total_amount,
        ];

        // Compile all parameters
        $params = [
            'transaction_details' => $transactionDetails,
            'item_details' => $itemDetails,
            'customer_details' => $customerDetails,
        ];

        try {
            // Get Snap payment token
            $snapToken = Snap::getSnapToken($params);
            return $snapToken;
        } catch (\Exception $e) {
            throw new \Exception('Midtrans Error: ' . $e->getMessage());
        }
    }

    /**
     * Handle payment notification from Midtrans
     *
     * @return array Notification data
     */
    public function handleNotification()
    {
        try {
            $notification = new Notification();

            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status ?? null;
            $orderNumber = $notification->order_id;
            $paymentType = $notification->payment_type;

            // Determine payment status
            $paymentStatus = 'pending';

            if ($transactionStatus == 'capture') {
                // For credit card, check fraud status
                // If fraud_status is null or 'accept', consider it as paid
                if ($fraudStatus == 'accept' || $fraudStatus == null) {
                    $paymentStatus = 'paid';
                } elseif ($fraudStatus == 'challenge') {
                    $paymentStatus = 'pending';
                }
            } elseif ($transactionStatus == 'settlement') {
                $paymentStatus = 'paid';
            } elseif ($transactionStatus == 'pending') {
                $paymentStatus = 'pending';
            } elseif ($transactionStatus == 'deny') {
                $paymentStatus = 'failed';
            } elseif ($transactionStatus == 'expire') {
                $paymentStatus = 'expired';
            } elseif ($transactionStatus == 'cancel') {
                $paymentStatus = 'cancelled';
            }

            return [
                'order_number' => $orderNumber,
                'payment_status' => $paymentStatus,
                'transaction_status' => $transactionStatus,
                'payment_type' => $paymentType,
                'transaction_id' => $notification->transaction_id ?? null,
                'fraud_status' => $fraudStatus,
                'raw_notification' => $notification,
            ];
        } catch (\Exception $e) {
            throw new \Exception('Notification Error: ' . $e->getMessage());
        }
    }

    /**
     * Get transaction status from Midtrans
     *
     * @param string $orderNumber
     * @return object Transaction status
     */
    public function getTransactionStatus($orderNumber)
    {
        try {
            return Transaction::status($orderNumber);
        } catch (\Exception $e) {
            throw new \Exception('Status Check Error: ' . $e->getMessage());
        }
    }

    /**
     * Cancel transaction
     *
     * @param string $orderNumber
     * @return object Cancel response
     */
    public function cancelTransaction($orderNumber)
    {
        try {
            return Transaction::cancel($orderNumber);
        } catch (\Exception $e) {
            throw new \Exception('Cancel Error: ' . $e->getMessage());
        }
    }
}
