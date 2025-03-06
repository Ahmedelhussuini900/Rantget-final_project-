<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Property;
use App\Models\User;

class RenterController extends Controller
{
    public function index()
    {
        $rentedProperties = Auth::user()->rentedProperties;
        return view('dashboard.renter', compact('rentedProperties'));
    }


    public function rentProperty($propertyId)
{
    $property = Property::findOrFail($propertyId);
    $tenant = Auth::user(); // المستأجر هو المستخدم الحالي

    // التأكد أن العقار غير مستأجر بالفعل
    if ($property->tenants()->where('tenant_id', $tenant->id)->exists()) {
        return back()->with('error', 'العقار مؤجر بالفعل لهذا المستخدم.');
    }

    // إضافة العلاقة باستخدام attach()
    $property->tenants()->attach($tenant->id);

    return back()->with('success', 'تم تأجير العقار بنجاح!');
}

}
