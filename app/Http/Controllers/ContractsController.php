<?php

namespace App\Http\Controllers;

use App\Models\Contract;
use App\Models\User;
use App\Models\Property;
use Illuminate\Http\Request;

class ContractsController extends Controller
{
    public function index()
    {
        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
    }

    public function create()
    {
        $properties = Property::all();
        $landlords = User::where('role', 'landlord')->get();
        $tenants = User::where('role', 'tenant')->get();

        return view('contracts.create', compact('properties', 'landlords', 'tenants'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'landlord_id' => 'required|exists:users,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_amount' => 'required|numeric|min:0',
            'insurance_amount' => 'required|numeric',
            'contract_image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penalty_amount' => 'required|numeric',
        ]);

        // تخزين الصورة
        if ($request->hasFile('contract_image')) {
            $contractImagePath = $request->file('contract_image')->store('contract_image', 'public');
            $validatedData = $request->all();
            $validatedData['contract_image'] = $contractImagePath;
        } else {
            $validatedData = $request->all();
        }

        Contract::create($validatedData);

        return redirect()->route('contracts.index')->with('success', 'Contract created successfully.');
    }

    public function show(Contract $contract)
    {
        return view('contracts.show', compact('contract'));
    }

    public function edit(Contract $contract)
    {
        $properties = Property::all();
        $landlords = User::where('role', 'landlord')->get();
        $tenants = User::where('role', 'tenant')->get();

        return view('contracts.edit', compact('contract', 'properties', 'landlords', 'tenants'));
    }

    public function update(Request $request, Contract $contract)
    {
        $request->validate([
            'property_id' => 'required|exists:properties,id',
            'landlord_id' => 'required|exists:users,id',
            'tenant_id' => 'required|exists:users,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_amount' => 'required|numeric|min:0',
            'insurance_amount' => 'required|numeric',
            'contract_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'penalty_amount' => 'required|numeric',
        ]);

        $validatedData = $request->all();

        // تحديث الصورة في حالة تم رفع صورة جديدة
        if ($request->hasFile('contract_image')) {
            $contractImagePath = $request->file('contract_image')->store('contract_image', 'public');
            $validatedData['contract_image'] = $contractImagePath;
        }

        $contract->update($validatedData);

        return redirect()->route('contracts.index')->with('success', 'Contract updated successfully.');
    }

    public function destroy(Contract $contract)
    {
        $contract->delete();
        return redirect()->route('contracts.index')->with('success', 'Contract deleted successfully.');
    }
}
