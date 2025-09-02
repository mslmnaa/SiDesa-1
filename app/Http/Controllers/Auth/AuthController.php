<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            if (auth()->user()->isAdmin()) {
                return redirect()->route('admin.dashboard');
            }
            
            return redirect()->intended(route('home'));
        }

        return back()->withErrors([
            'email' => 'Kredensial yang diberikan tidak cocok dengan data kami.',
        ])->onlyInput('email');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone' => $validated['phone'],
            'address' => $validated['address'],
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', 'Registrasi berhasil!');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }

    public function profile()
    {
        $user = auth()->user();
        
        try {
            // Get user orders
            $orders = $user->orders()
                ->with(['orderItems.product'])
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'orders_page');
            
            // Get user infaq history  
            $infaqs = \App\Models\Infaq\Infaq::where('donor_email', $user->email)
                ->orWhere('donor_phone', $user->phone)
                ->orderBy('created_at', 'desc')
                ->paginate(5, ['*'], 'infaq_page');
            
            // Debug info
            \Log::info('Profile Debug', [
                'user_id' => $user->id,
                'user_email' => $user->email,
                'orders_count' => $orders->count(),
                'infaqs_count' => $infaqs->count()
            ]);
            
        } catch (\Exception $e) {
            \Log::error('Profile Error: ' . $e->getMessage());
            // Fallback to empty collections
            $orders = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 5);
            $infaqs = new \Illuminate\Pagination\LengthAwarePaginator([], 0, 5);
        }
        
        return view('auth.profile', compact('orders', 'infaqs'));
    }

    public function updateProfile(Request $request)
    {
        $user = auth()->user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:500',
            'password' => ['nullable', 'confirmed', Password::min(8)],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'address' => $validated['address'],
        ];

        if (!empty($validated['password'])) {
            $updateData['password'] = Hash::make($validated['password']);
        }

        $user->update($updateData);

        return redirect()->route('profile')->with('success', 'Profile berhasil diperbarui!');
    }
}
