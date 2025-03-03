@extends('layout.master')

@section('content')
<div class="container mt-5">
    <h1>Create Contract</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('contracts.index') }}" class="btn btn-secondary">Back to Contracts</a>
    </div>

    <form action="{{ route('contracts.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-3">
            <label for="properties_id" class="form-label">Property</label>
            <select name="property_id" id="property_id" class="form-control" required>
                @foreach($properties as $property)
                    <option value="{{ $property->id }}">{{ $property->title }}</option>
                @endforeach
            </select>

        </div>

        <div class="mb-3">
            <label for="landlord_id" class="form-label">Landlord</label>
            <select name="landlord_id" id="landlord_id" class="form-control" required>
                @foreach($landlords as $landlord)
                    <option value="{{ $landlord->id }}">{{ $landlord->fullname }}</option>
                @endforeach
            </select>

        </div>

        <div class="mb-3">
            <label for="tenant_id" class="form-label">Tenant</label>
            <select name="tenant_id" id="tenant_id" class="form-control" required>
                @foreach($tenants as $tenant)
                    <option value="{{ $tenant->id }}">{{ $tenant->fullname }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" name="total_amount" id="total_amount" class="form-control" required step="0.01">
        </div>

        <div class="mb-3">
            <label for="insurance_amount" class="form-label">Insurance Amount</label>
            <input type="number" name="insurance_amount" id="insurance_amount" class="form-control" required step="0.01">
        </div>

        <div class="mb-3">
            <label for="penalty_amount" class="form-label">Penalty Amount</label>
            <input type="number" name="penalty_amount" id="penalty_amount" class="form-control" required step="0.01">
        </div>

        <div class="mb-3">
            <label for="contract_image" class="form-label">Contract Image</label>
            <input type="file" name="contract_image" id="contract_image" class="form-control" required>
                @error('contract_image')
                    <div class="text-danger">{{ $message }}</div>
                @enderror

        </div>


        <button type="submit" class="btn btn-primary">Create Contract</button>
    </form>
</div>
@endsection
