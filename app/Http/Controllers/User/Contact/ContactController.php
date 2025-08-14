<?php

namespace App\Http\Controllers\User\Contact;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\System\Setting;

class ContactController extends Controller
{
    public function index()
    {
        return view('user.contact.index');
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|min:10',
        ]);

        // Get village head email from settings
        $villageHeadEmail = Setting::get('village_head_email');
        
        if (!$villageHeadEmail) {
            return back()->with('error', 'Email kepala desa belum diatur. Silakan hubungi administrator.');
        }

        try {
            // Send email to village head
            Mail::send('emails.contact', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
                'messageContent' => $request->message,
            ], function ($mail) use ($request, $villageHeadEmail) {
                $mail->to($villageHeadEmail)
                     ->subject('Pesan Kontak Website Desa: ' . $request->subject)
                     ->from(config('mail.from.address'), $request->name)
                     ->replyTo($request->email, $request->name);
            });

            return back()->with('success', 'Pesan Anda berhasil dikirim ke kepala desa. Terima kasih!');

        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Contact form email error: ' . $e->getMessage());
            
            // In production, show generic error. In development, show detailed error.
            $errorMessage = app()->environment('production') 
                ? 'Terjadi kesalahan saat mengirim pesan. Silakan coba lagi atau hubungi administrator.'
                : 'Error: ' . $e->getMessage();
            
            return back()->with('error', $errorMessage);
        }
    }
}
