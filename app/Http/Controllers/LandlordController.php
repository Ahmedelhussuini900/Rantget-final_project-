<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property; // تأكد من استيراد الموديل

class LandlordController extends Controller
{
    public function index()
    {
        $properties = Property::all(); // جلب جميع العقارات من قاعدة البيانات
        return view('dashboard.landlord', compact('properties')); // تمرير المتغير إلى الـ View
    }
}
