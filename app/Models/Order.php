<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'shipping_address_id',
        'total_amount',
        'shipping_cost',
        'shipping_service',
        'shipping_etd',
        'shipping_tracking_number',
        'shipping_courier',
        'shipping_resi',
        'shipping_status',
        'shipping_history',
        'status',
        'payment_status',
        'payment_method',
        'payment_proof',
        'customer_notes',
        'admin_notes',
        'paid_at',
        'shipped_at',
        'delivered_at',
        'tracking_updated_at',
        'completed_at',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_transaction_status',
        'midtrans_snap_token',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'tracking_updated_at' => 'datetime',
        'completed_at' => 'datetime',
        'shipping_history' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function shippingAddress()
    {
        return $this->belongsTo(ShippingAddress::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('payment_status', 'paid');
    }

    /**
     * Check if order has tracking info
     */
    public function hasTracking()
    {
        return !empty($this->shipping_resi) && !empty($this->shipping_courier);
    }

    /**
     * Check if order is shipped
     */
    public function isShipped()
    {
        return !empty($this->shipped_at);
    }

    /**
     * Check if order is delivered
     */
    public function isDelivered()
    {
        return $this->shipping_status === 'delivered' && !empty($this->delivered_at);
    }

    /**
     * Get tracking URL for external website
     */
    public function getTrackingUrl()
    {
        if (!$this->hasTracking()) {
            return null;
        }

        $urls = [
            'jne' => 'https://www.jne.co.id/id/tracking/trace',
            'jnt' => 'https://www.jet.co.id/track',
            'sicepat' => 'https://www.sicepat.com/checkAwb',
            'tiki' => 'https://www.tiki.id/id/tracking',
            'pos' => 'https://www.posindonesia.co.id/id/tracking',
            'ninja' => 'https://www.ninjaxpress.co/id-id/tracking',
            'anteraja' => 'https://www.anteraja.id/tracking',
        ];

        return $urls[strtolower($this->shipping_courier)] ?? null;
    }

    /**
     * Get status badge color
     */
    public function getShippingStatusColor()
    {
        return match($this->shipping_status) {
            'delivered' => 'green',
            'in_transit' => 'blue',
            'on_process' => 'yellow',
            'failed' => 'red',
            default => 'gray'
        };
    }
}
