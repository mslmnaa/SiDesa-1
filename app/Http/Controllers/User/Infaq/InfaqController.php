<?php

namespace App\Http\Controllers\User\Infaq;

use App\Http\Controllers\Controller;

use App\Models\Infaq\Infaq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InfaqController extends Controller
{
    public function index()
    {
        // Get recent donations (verified and completed) for display
        $recentDonations = Infaq::whereIn('status', ['verified', 'completed'])
            ->where('anonymous', false)
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        // Calculate total collected
        $totalCollected = Infaq::whereIn('status', ['verified', 'completed'])
            ->sum('amount');

        // Count total donors
        $totalDonors = Infaq::whereIn('status', ['verified', 'completed'])
            ->count();

        return view('user.infaq.index', compact('recentDonations', 'totalCollected', 'totalDonors'));
    }

    public function create()
    {
        return view('user.infaq.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'donor_name' => 'required|string|max:255',
            'donor_phone' => 'nullable|string|max:20',
            'donor_email' => 'nullable|email|max:255',
            'amount' => 'required|numeric|min:10000', // minimum 10rb
            'message' => 'nullable|string|max:1000',
            'payment_method' => 'required|in:transfer_bank,e_wallet,qris,cash',
            'payment_proof' => 'required_if:payment_method,transfer_bank,e_wallet,qris|image|mimes:jpeg,png,jpg|max:2048',
            'anonymous' => 'boolean'
        ], [
            'donor_name.required' => 'Nama donatur wajib diisi.',
            'amount.required' => 'Jumlah donasi wajib diisi.',
            'amount.min' => 'Minimum donasi adalah Rp 10.000.',
            'payment_method.required' => 'Metode pembayaran wajib dipilih.',
            'payment_proof.required_if' => 'Bukti pembayaran wajib diupload untuk transfer bank, e-wallet, dan QRIS.',
            'payment_proof.image' => 'Bukti pembayaran harus berupa gambar.',
            'payment_proof.max' => 'Ukuran file maksimal 2MB.'
        ]);

        $data = $request->only([
            'donor_name', 'donor_phone', 'donor_email', 'amount', 
            'message', 'payment_method', 'anonymous'
        ]);

        // Handle payment proof upload
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('infaq/payment-proofs', 'public');
            $data['payment_proof'] = $path;
        }

        // Set status based on payment method
        $data['status'] = $request->payment_method === 'cash' ? 'pending' : 'pending';

        $infaq = Infaq::create($data);

        return redirect()->route('infaq.show', $infaq)
            ->with('success', 'Terima kasih atas donasi Anda! Donasi Anda akan segera diverifikasi oleh admin.');
    }

    public function show(Infaq $infaq)
    {
        return view('user.infaq.show', compact('infaq'));
    }
}
