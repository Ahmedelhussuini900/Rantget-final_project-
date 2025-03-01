@extends('layout.master')

@section('content')
<div class="container mt-5">
    <h1>Contract Details</h1>

    <div class="card">
        <div class="card-body">
            <h5 class="card-title">Contract Information</h5>
            <hr>

            <p><strong>Property:</strong> {{ $contract->property->title }}</p>
            <p><strong>Landlord:</strong> {{ $contract->landlord->fullname }}</p>
            <p><strong>Tenant:</strong> {{ $contract->tenant->fullname }}</p>
            <p><strong>Start Date:</strong> {{ $contract->start_date }}</p>
            <p><strong>End Date:</strong> {{ $contract->end_date }}</p>
            <p><strong>Total Amount:</strong> {{ $contract->total_amount }} EGP</p>
            <p><strong>Insurance Amount:</strong> {{ $contract->insurance_amount }} EGP</p>
            <div class="mb-3">
                <strong>Contract Image:</strong> <br>
                <img src="{{ asset('storage/' . $contract->contract_image) }}" class="img-fluid" style="max-width: 300px;">
            </div>
            <p><strong>Penalty Amount:</strong> {{ $contract->penalty_amount }} EGP</p>

            

            <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Back to Contracts</a>
        </div>
    </div>
</div>
@endsection
