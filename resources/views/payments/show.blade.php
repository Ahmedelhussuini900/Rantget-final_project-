@extends('layout.master')

@section('title','show Payment')

@section('content')

    <div class="container mt-4">
        <h2>Payment Details</h2>
        <div class="card p-3">
            <p><strong>Contract ID:</strong> {{ $payment->contract->id }}</p>
            <p><strong>Amount:</strong> ${{ number_format($payment->amount, 2) }}</p>
            <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
            @if($payment->payment_method == 'Card')
                <p><strong>Card Number:</strong> {{ $payment->card_number }}</p>
            @endif
            <p><strong>Payment Date:</strong> {{ $payment->payment_date }}</p>
            <p><strong>Status:</strong>
                <span class="badge
                    @if($payment->status == 'Completed') bg-success
                    @elseif($payment->status == 'Pending') bg-warning
                    @elseif($payment->status == 'Cancelled') bg-danger
                    @else bg-secondary
                    @endif">
                    {{ $payment->status }}
                </span>
            </p>

            <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary">Edit</a>
            <form action="{{ route('payments.destroy', $payment->id) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
            </form>
            <a href="{{ route('payments.index') }}" class="btn btn-secondary">Back</a>
        </div>
    </div>
@endsection
