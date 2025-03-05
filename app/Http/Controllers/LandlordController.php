<?php

namespace App\Http\Controllers;

use App\Http\Middleware\AuthMiddleware;
use Illuminate\Http\Request;
use App\Models\Property;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; 

class LandlordController extends Controller
{
     public function index()
        {
            $user = Auth::user();
    
            if ($user) {
                // ✅ جلب العقارات الخاصة بالمستخدم عبر العلاقة Many-to-Many
                $properties = $user->properties;
    
                return view('dashboard.landlord', compact('properties'));
            }
    
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً!');
        }
}