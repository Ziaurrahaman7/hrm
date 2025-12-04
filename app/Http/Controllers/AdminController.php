<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function dashboard()
    {
        $stats = [
            'total_users' => User::count(),
            'admin_users' => User::where('is_admin', true)->count(),
            'regular_users' => User::where('is_admin', false)->count(),
        ];
        
        return view('admin.dashboard', compact('stats'));
    }
    
    public function users()
    {
        $users = User::latest()->paginate(10);
        return view('admin.users', compact('users'));
    }
    
    public function createUser()
    {
        return view('admin.create-user');
    }
    
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'is_admin' => 'boolean'
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'is_admin' => $request->has('is_admin')
        ]);

        return redirect()->route('admin.users')->with('success', 'User created successfully.');
    }
    
    public function editUser(User $user)
    {
        return view('admin.edit-user', compact('user'));
    }
    
    public function updateUser(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8|confirmed',
            'is_admin' => 'boolean'
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'is_admin' => $request->has('is_admin')
        ];
        
        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        $user->update($data);
        return redirect()->route('admin.users')->with('success', 'User updated successfully.');
    }
    
    public function destroyUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
}
