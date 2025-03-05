<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Property;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PropertiesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $properties = Property::all();
        return view("properties.index", compact("properties"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("properties.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // ✅ التأكد من أن المستخدم مسجل دخول
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً!');
        }

        // ✅ التحقق من صحة البيانات
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);

        // ✅ رفع الصورة وتخزين المسار
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('properties_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // ✅ إنشاء العقار
        $property = Property::create($validatedData);

        // ✅ إرفاق العقار بالمستخدم في الجدول الوسيط
// ✅ تأكد من استخدام () عند استدعاء العلاقة

if (Auth::check()) {
    Auth::User()->properties()->syncWithoutDetaching([$property->id]);
} else {
    return redirect()->route('login')->with('error', 'يجب تسجيل الدخول أولاً!');
}
  
        return redirect()->route('dashboard.landlord')->with('success', 'Property created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Property $property)
    {
        return view('properties.show', compact('property'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Property $property)
    {
        return view('properties.edit', compact('property'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Property $property)
    {
        // ✅ التحقق من صحة البيانات
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'location' => 'required|string|max:255',
            'price' => 'required|numeric',
            'status' => 'required|in:unavailable,reserved,available,rent',
        ]);

        // ✅ تحديث الصورة في حالة تغييرها
        if ($request->hasFile('image')) {
            // حذف الصورة القديمة
            if ($property->image) {
                Storage::disk('public')->delete($property->image);
            }

            // رفع الصورة الجديدة
            $imagePath = $request->file('image')->store('properties_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // ✅ تحديث العقار
        $property->update($validatedData);

        return redirect()->route('properties.show', $property->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Property $property)
    {
        // ✅ حذف الصورة في حالة وجودها
        if ($property->image) {
            Storage::disk('public')->delete($property->image);
        }

        // ✅ حذف العقار
        $property->delete();

        return redirect()->route('properties.index')->with('success', 'Property deleted successfully.');
    }
}
