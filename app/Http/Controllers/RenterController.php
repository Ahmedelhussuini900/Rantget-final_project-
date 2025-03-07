<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Contract;
use App\Models\Property;
use App\Models\User;
use App\Models\Payment;

class RenterController extends Controller
{
    public function index()
    {
        $renter = Auth::user();

        $rentedproperties = Property::whereHas('contracts', function ($query) use ($renter) {
            $query->where('tenant_id', $renter->id);
        })->get();

        return view('dashboard.renter', compact('rentedproperties'));
    }

    public function show(Property $property)
    {
        $contract = Contract::where('property_id', $property->id)
                            ->where('tenant_id', auth()->id())
                            ->first();

        if (!$contract) {
            return redirect()->route('dashboard.renter')->with('error', 'لا يوجد عقد لهذا العقار.');
        }

        $landlord = $property->landlord;

        return view('dashboard.rented-properties', compact('property', 'contract', 'landlord'));
    }

    public function rentProperty($propertyId)
    {
        $property = Property::findOrFail($propertyId);
        $tenant = Auth::user();

        // التحقق مما إذا كان العقار مستأجرًا بالفعل من قبل نفس المستأجر
        $contractExists = Contract::where('property_id', $propertyId)
            ->where('tenant_id', $tenant->id)
            ->exists();

        if ($contractExists) {
            return back()->with('error', 'العقار مؤجر بالفعل لهذا المستخدم.');
        }

        // إنشاء عقد جديد بين المستأجر والمالك
        Contract::create([
            'property_id' => $property->id,
            'tenant_id' => $tenant->id,
            'landlord_id' => $property->landlord_id,
            'start_date' => Carbon::now(),
            'end_date' => Carbon::now()->addYear(),
            'rent_amount' => $property->rent_price
        ]);

        return back()->with('success', 'تم تأجير العقار بنجاح!');
    }

    public function getTenantContract(User $tenant)
    {
        $landlord = auth()->user();

        $contract = Contract::whereHas('property', function ($query) use ($landlord) {
            $query->where('landlord_id', $landlord->id);
        })->where('tenant_id', $tenant->id)->first();

        if (!$contract) {
            return redirect()->back()->with('error', 'لا يوجد عقد لهذا المستأجر.');
        }

        return view('landlord.contract', compact('contract'));
    }

    public function getTenants()
    {
        $landlord = auth()->user();

        $tenants = User::whereHas('contracts', function ($query) use ($landlord) {
            $query->whereHas('property', function ($q) use ($landlord) {
                $q->where('landlord_id', $landlord->id);
            });
        })->get();

        return view('landlord.tenants', compact('tenants'));
    }

    public function showMonths($contractId)
    {
        $contract = Contract::with('tenant')->findOrFail($contractId);

        $startDate = Carbon::parse($contract->start_date);
        $endDate = Carbon::parse($contract->end_date);
        $currentDate = Carbon::now();

        // جلب جميع المدفوعات لهذا العقد دفعة واحدة
        $payments = Payment::where('contract_id', $contractId)
                            ->pluck('payment_date')
                            ->map(fn($date) => Carbon::parse($date)->format('Y-m'));

        $months = [];

        while ($startDate->lte($endDate)) {
            $year = $startDate->year;
            $month = $startDate->month;
            $monthKey = $startDate->format('Y-m');
            $monthName = $startDate->format('F Y');

            if ($payments->contains($monthKey)) {
                $status = 'paid';
            } elseif ($startDate->lt($currentDate)) {
                $status = 'late';
            } else {
                $status = 'unpaid';
            }

            $months[] = [
                'number' => $month,
                'year' => $year,
                'name' => $monthName,
                'status' => $status
            ];

            $startDate->addMonth();
        }

        return view('dashboard.months', compact('contract', 'months'));
    }
}
