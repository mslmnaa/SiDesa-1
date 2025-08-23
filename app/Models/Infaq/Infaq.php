<?php

namespace App\Models\Infaq;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Infaq extends Model
{
    use HasFactory;

    protected $fillable = [
        'donor_name',
        'donor_phone',
        'donor_email',
        'amount',
        'message',
        'payment_method',
        'payment_proof',
        'status',
        'anonymous',
        'admin_notes',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'anonymous' => 'boolean',
        'verified_at' => 'datetime',
    ];

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
            default => 'Tidak Dikenal'
        };
    }

    public function getPaymentMethodLabelAttribute()
    {
        return match($this->payment_method) {
            'transfer_bank' => 'Transfer Bank',
            'e_wallet' => 'E-Wallet',
            'cash' => 'Tunai',
            default => 'Tidak Dikenal'
        };
    }
}
