@extends('layout.master')

@section('content')

<div class="container">
    <h2>Add Payment</h2>
    <form action="{{ route('payments.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Contract:</label>
            <select name="contract_id" class="form-control">
                @foreach($contracts as $contract)
                    <option value="{{ $contract->id }}">{{ $contract->id }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label>Amount:</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Payment Method:</label>
            <input type="text" name="payment_method" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Card Number:</label>
            <input type="text" name="card_number" class="form-control">
        </div>
        <div class="form-group">
            <label>Payment Date:</label>
            <input type="date" name="payment_date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Status:</label>
            <select name="status" class="form-control">
                <option value="Completed">Completed</option>
                <option value="Cancelled">Cancelled</option>
                <option value="Failed">Failed</option>
                <option value="Pending">Pending</option>
                <option value="Late">Late</option>
            </select>
        </div>
        <button type="submit" class="btn btn-success">Save Payment</button>
    </form>
</div>
@endsection
