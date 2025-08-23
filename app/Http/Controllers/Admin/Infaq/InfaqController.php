<?php

namespace App\Http\Controllers\Admin\Infaq;

use App\Http\Controllers\Controller;
use App\Models\Infaq\Infaq;
use Illuminate\Http\Request;

class InfaqController extends Controller
{
    public function index(Request $request)
    {
        $query = Infaq::with('verifier')->orderBy('created_at', 'desc');

        // Filter by status
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->has('payment_method') && $request->payment_method) {
            $query->where('payment_method', $request->payment_method);
        }

        // Search by donor name
        if ($request->has('search') && $request->search) {
            $query->where('donor_name', 'like', '%' . $request->search . '%');
        }

        $infaqs = $query->paginate(20);

        // Statistics
        $statistics = [
            'total_pending' => Infaq::where('status', 'pending')->count(),
            'total_verified' => Infaq::where('status', 'verified')->count(),
            'total_completed' => Infaq::where('status', 'completed')->count(),
            'total_rejected' => Infaq::where('status', 'rejected')->count(),
            'total_amount_verified' => Infaq::whereIn('status', ['verified', 'completed'])->sum('amount'),
            'total_amount_pending' => Infaq::where('status', 'pending')->sum('amount'),
        ];

        return view('admin.infaq.index', compact('infaqs', 'statistics'));
    }

    public function show(Infaq $infaq)
    {
        $infaq->load('verifier');
        return view('admin.infaq.show', compact('infaq'));
    }

    public function updateStatus(Request $request, Infaq $infaq)
    {
        $request->validate([
            'status' => 'required|in:pending,verified,completed,rejected',
            'admin_notes' => 'nullable|string|max:1000'
        ]);

        $infaq->update([
            'status' => $request->status,
            'admin_notes' => $request->admin_notes,
            'verified_by' => $request->status === 'verified' ? auth()->id() : $infaq->verified_by,
            'verified_at' => $request->status === 'verified' ? now() : $infaq->verified_at,
        ]);

        $statusLabel = match($request->status) {
            'pending' => 'Menunggu Verifikasi',
            'verified' => 'Terverifikasi',
            'completed' => 'Selesai',
            'rejected' => 'Ditolak',
        };

        return redirect()->route('admin.infaq.index')
            ->with('success', "Status donasi berhasil diubah menjadi: {$statusLabel}");
    }

    public function verifyPayment(Infaq $infaq)
    {
        if ($infaq->status !== 'pending') {
            return redirect()->back()->with('error', 'Donasi ini sudah diverifikasi atau tidak dalam status pending.');
        }

        $infaq->update([
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'verified_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Donasi berhasil diverifikasi.');
    }

    public function completeDistribution(Infaq $infaq)
    {
        if ($infaq->status !== 'verified') {
            return redirect()->back()->with('error', 'Donasi harus dalam status terverifikasi untuk bisa diselesaikan.');
        }

        $infaq->update([
            'status' => 'completed'
        ]);

        return redirect()->back()->with('success', 'Donasi berhasil diselesaikan. Dana telah disalurkan.');
    }

    public function reject(Request $request, Infaq $infaq)
    {
        $request->validate([
            'admin_notes' => 'required|string|max:1000'
        ]);

        $infaq->update([
            'status' => 'rejected',
            'admin_notes' => $request->admin_notes,
        ]);

        return redirect()->back()->with('success', 'Donasi telah ditolak.');
    }
}
