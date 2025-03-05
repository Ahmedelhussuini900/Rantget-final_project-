<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // Show the unified login/register page
    public function showAuthForm()
    {
        return view('auth.login');
    }

    // Handle Login
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:8',
        ]);

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate(); // Prevent session fixation attacks

            $user = Auth::user(); // Get logged-in user

            // Redirect based on role
            if ($user->role === 'landlord') {
                return redirect()->route('dashboard.landlord');
            } elseif ($user->role === 'tenant') {
                return redirect()->route('dashboard.renter');
            }

            return redirect()->route('dashboard');
        }

        return back()->withErrors([
            'email' => 'Invalid credentials. Please try again.',
        ]);
    }

    // Handle Registration

    public function showRegisterForm()
    {
        return view('auth.register'); // Make sure this file exists in resources/views/auth/register.blade.php
    }
    public function registerafter(Request $request)
    {
        $validatedData = $request->validate([
            'fullname' => 'required|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
            'age' => 'required|numeric|min:20',
            'phone' => 'required|digits:11|unique:users',
            'role' => 'required|string|in:landlord,tenant',
            'id_identify' => 'required|digits:14|unique:users',
            'id_identify_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ], [
            'phone.digits' => 'The phone number must be exactly 11 digits.',
            'id_identify.digits' => 'The ID number must be exactly 14 digits.',
        ]);
    
        // Handle file uploads
        $validatedData['id_identify_image'] = $request->file('id_identify_image')->store('id_identify_images', 'public');
        $validatedData['image'] = $request->file('image')->store('user_images', 'public');
        $validatedData['password'] = Hash::make($request->password); // Hash password
    
        // Create user
        $user = User::create($validatedData);
    
        // Automatically log in after registration
        Auth::login($user);
    
        // Check if the user is admin
        if ($user->email === 'admin@gmail.com' && Hash::check('admin123', $user->password)) {
            return redirect()->route('admin.dashboard');
        }
    
        // Redirect based on user role
        return redirect()->route($user->role === 'landlord' ? 'dashboard.landlord' : 'dashboard.tenant');
    }
    

    // Handle Logoutac
    public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/auth'); // Make sure /auth is a valid route
}

public function landlordDashboard()
{
    $user = Auth::user(); 
    return view('dashboard.landlord', compact('user')); // ✅ Pass user to the view
}


}