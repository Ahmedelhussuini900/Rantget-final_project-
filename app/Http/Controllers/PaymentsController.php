<?php
namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Contract;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    /**
     * Display a listing of payments.
     */
    public function index()
    {
        $payments = Payment::with('contract')->latest()->get(); // Fetch latest first
        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create()
    {
        $contracts = Contract::all(); // Fetch contracts for dropdown
        return view('payments.create', compact('contracts'));
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'card_number' => 'nullable|string|max:255|required_if:payment_method,Card',
            'payment_date' => 'required|date',
            'status' => 'required|in:Completed,Cancelled,Failed,Pending,Late',
        ]);

        Payment::create($validatedData);

        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        return view('payments.show', compact('payment'));
    }

    /**
     * Show the form for editing a payment.
     */
    public function edit(Payment $payment)
    {
        $contracts = Contract::all();
        return view('payments.edit', compact('payment', 'contracts'));
    }

    /**
     * Update the specified payment.
     */
    public function update(Request $request, Payment $payment)
    {
        $validatedData = $request->validate([
            'contract_id' => 'required|exists:contracts,id',
            'amount' => 'required|numeric|min:0',
            'payment_method' => 'required|string|max:255',
            'card_number' => 'nullable|string|max:255|required_if:payment_method,Card',
            'payment_date' => 'required|date',
            'status' => 'required|in:Completed,Cancelled,Failed,Pending,Late',
        ]);

        $payment->update($validatedData);

        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    /**
     * Remove the specified payment from storage.
     */
    public function destroy(Payment $payment)
    {
        $payment->delete();
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }
}
