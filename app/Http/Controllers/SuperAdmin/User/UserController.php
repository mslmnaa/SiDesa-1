<?php

namespace App\Http\Controllers\SuperAdmin\User;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $query = User::query();
        
        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
            });
        }
        
        // Role filter
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }
        
        $users = $query->latest()->paginate(10);
        
        // Get statistics
        $totalUsers = User::count();
        $regularUsers = User::where('role', 'user')->count();
        $admins = User::where('role', 'admin')->count();
        $superAdmins = User::where('role', 'superadmin')->count();
        
        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'regularUsers', 
            'admins',
            'superAdmins'
        ));
    }
    
    public function create()
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        return view('admin.users.create');
    }
    
    public function store(Request $request)
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:user,admin,superadmin'
        ]);
        
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role,
            'email_verified_at' => now()
        ]);
        
        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil ditambahkan.');
    }
    
    public function show(User $user)
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        return view('admin.users.show', compact('user'));
    }
    
    public function edit(User $user)
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        // Prevent editing own account through this interface
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.show', $user)
                            ->with('error', 'Gunakan halaman profile untuk mengedit akun Anda sendiri.');
        }
        
        return view('admin.users.edit', compact('user'));
    }
    
    public function update(Request $request, User $user)
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        // Prevent editing own account through this interface
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.show', $user)
                            ->with('error', 'Gunakan halaman profile untuk mengedit akun Anda sendiri.');
        }
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'role' => 'required|in:user,admin,superadmin'
        ]);
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role' => $request->role
        ];
        
        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }
        
        $user->update($updateData);
        
        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil diperbarui.');
    }
    
    public function destroy(User $user)
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                            ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }
        
        
        $user->delete();
        
        return redirect()->route('admin.users.index')
                        ->with('success', 'User berhasil dihapus.');
    }
    
    public function toggleRole(Request $request, User $user)
    {
        // Only superadmin can access this
        if (!auth()->user()->isSuperAdmin()) {
            abort(403, 'Unauthorized');
        }
        
        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return response()->json([
                'success' => false,
                'message' => 'Anda tidak dapat mengubah role akun Anda sendiri.'
            ], 400);
        }
        
        $request->validate([
            'role' => 'required|in:user,admin,superadmin'
        ]);
        
        $user->update(['role' => $request->role]);
        
        return response()->json([
            'success' => true,
            'message' => 'Role user berhasil diperbarui.',
            'role' => $user->role
        ]);
    }
}
