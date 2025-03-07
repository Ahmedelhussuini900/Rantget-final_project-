@extends('layout.master')

 @section('content')

<div class="container">
    <h2 class="mb-4">Make Payment for {{ $month }}/{{ $year }}</h2>

    <div class="card">
        <div class="card-body">
            <h4>Contract ID: {{ $contract->id }}</h4>
            <h5>Tenant: {{ $contract->tenant->name }}</h5>
            <h5>Property: {{ $contract->property->name ?? 'N/A' }}</h5>
            <h5>Amount: <strong>{{ number_format($contract->total_amount / 12, 2) }} EGP</strong></h5>
        </div>
    </div>

    <form action="{{ route('payments.store') }}" method="POST">
        @csrf

        <input type="hidden" name="contract_id" value="{{ $contract->id }}">
        <input type="hidden" name="month" value="{{ $month }}">
        <input type="hidden" name="year" value="{{ $year }}">

        <div class="mb-3">
            <label class="form-label">Card Number</label>
            <input type="text" name="card_number" class="form-control" placeholder="1234 5678 9012 3456" required>
        </div>

        <div class="row">
            <div class="col-md-6 mb-3">
                <label class="form-label">Expiry Date (MM/YY)</label>
                <input type="text" name="expiry_date" class="form-control" placeholder="12/24" required>
            </div>

            <div class="col-md-6 mb-3">
                <label class="form-label">CVV</label>
                <input type="text" name="cvv" class="form-control" placeholder="123" required>
            </div>
        </div>

        <div class="mb-3">
            <label class="form-label">Amount</label>
            <input type="text" name="amount" class="form-control" value="{{ $contract->total_amount / 12 }}" readonly>
        </div>

        <button type="submit" class="btn btn-success">Pay Now 💳</button>
    </form>
</div>

@endsection
