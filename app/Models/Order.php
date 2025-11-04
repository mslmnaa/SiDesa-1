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
        'status',
        'payment_status',
        'payment_method',
        'payment_proof',
        'customer_notes',
        'admin_notes',
        'paid_at',
        'completed_at',
        'midtrans_order_id',
        'midtrans_transaction_id',
        'midtrans_transaction_status',
        'midtrans_snap_token',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'completed_at' => 'datetime',
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
}
