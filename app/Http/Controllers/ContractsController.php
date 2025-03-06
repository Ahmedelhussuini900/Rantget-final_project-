<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContractsController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }

    public function create(Request $request)
    {
        $user = Auth::user();
        // $properties = Property::where('landlord_id', auth()->id())->select('id', 'name')->get();

        // التحقق مما إذا كان هناك `property_id` في الرابط
        if ($request->has('property_id')) {
            $properties = Property::where('id', $request->property_id)->get();
        } else {
            $properties = Property::where('landlord_id', auth()->id())->get();
        }

        $landlords = User::where('id', $user->id)->get();
        $tenants = User::where('role', 'tenant')->get();
        // dd($properties->toArray());


        return view('contracts.create', compact('properties', 'tenants', 'landlords'));
    }


public function store(Request $request)
{
    $data = $request->validate([
        'property_id' => 'required|exists:properties,id',
        'tenant_id' => 'required|exists:users,id',
        'start_date' => 'required|date',
        'end_date' => 'required|date|after:start_date',
        'total_amount' => 'required|numeric|min:0',
        'insurance_amount' => 'required|numeric',
        'contract_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'penalty_amount' => 'nullable|numeric|min:0',
    ]);

    $property = Property::findOrFail($data['property_id']);

    // الحصول على المالك الأول للعقار
    $landlord = $property->landlords()->select('id')->first();
    if (!$landlord) {
        return back()->withErrors(['property_id' => 'The selected property does not have a landlord.']);
    }

    // رفع الصورة إن وجدت
    if ($request->hasFile('contract_image')) {
        $data['contract_image'] = $request->file('contract_image')->store('contract_images', 'public');
    }

    // إنشاء العقد باستخدام `fill()` لتسهيل التعديلات مستقبلاً
    $contract = new Contract();
    $contract->fill(array_merge($data, ['landlord_id' => $landlord->id]));
    $contract->save();
    dd($contract->all());

    return redirect()->route('contracts.index')->with('success', 'Contract created successfully.');
}
    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $user = Auth::user();
        $properties = Property::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id)->where('role', 'landlord');
        })->get();

        $tenants = User::where('role', 'tenant')->get();


        return view('contracts.edit', compact('contract', 'properties', 'tenants'));

    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_amount' => 'required|numeric|min:0',
            'insurance_amount' => 'required|numeric',
            'contract_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penalty_amount' => 'nullable|numeric|min:0',
        ]);

        $property = Property::findOrFail($request->property_id);
        $landlord = $property->landlords()->first();
        $landlord_id = $landlord ? $landlord->id : null;

        if ($request->hasFile('contract_image')) {
            if ($contract->contract_image && file_exists(storage_path('app/public/' . $contract->contract_image))) {
                unlink(storage_path('app/public/' . $contract->contract_image));
            }
            $contractImagePath = $request->file('contract_image')->storeAs(
                'contract_image',
                time() . '_' . $request->file('contract_image')->getClientOriginalName(),
                'public'
            );
        } else {
            $contractImagePath = $contract->contract_image;
        }

        $contract->update([
            'property_id' => $request->property_id,
            'landlord_id' => $landlord_id,
            'tenant_id' => $request->tenant_id,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'total_amount' => $request->total_amount,
            'insurance_amount' => $request->insurance_amount,
            'contract_image' => $contractImagePath,
            'penalty_amount' => $request->penalty_amount,
        ]);

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully.');
    }

    public function destroy(Contract $contract)
    {
        if ($contract->contract_image && file_exists(storage_path('app/public/' . $contract->contract_image))) {
            unlink(storage_path('app/public/' . $contract->contract_image));
        }

        $contract->delete();

        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully.');
    }
}
