@extends('layout.master')

@section('content')
<div class="container mt-5">
    <h1>All Contracts</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <a href="{{ route('contracts.create') }}" class="btn btn-primary">Create New Contract</a>
    </div>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Property</th>
                <th>Landlord</th>
                <th>Tenant</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Total Amount</th>
                <th>Insurance Amount</th>
                <th>Contract Image</th>
                <th>Penalty Amount</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($contracts as $contract)
                <tr>
                    <td>{{ $contract->id }}</td>
                    <td>{{ optional($contract->property)->title ?? 'N/A' }}</td>
                    <td>{{ $contract->landlord->fullname }}</td>
                    <td>{{ $contract->tenant->fullname }}</td>
                    <td>{{ $contract->start_date }}</td>
                    <td>{{ $contract->end_date }}</td>
                    <td>{{ $contract->total_amount }} EGP</td>
                    <td>{{ $contract->insurance_amount }} EGP</td>
                    <td>
                            @if($contract->contract_image)
                                <img src="{{ asset('storage/' . $contract->contract_image) }}" alt="Contract Image" class="img-fluid" style="max-width: 100px;">
                            @else
                                No Image
                            @endif
                        </td>

                    <td>{{ $contract->penalty_amount }} EGP</td>
                    
                    <td>
                        <a href="{{ route('contracts.show', $contract->id) }}" class="btn btn-info btn-sm">View</a>
                        <a href="{{ route('contracts.edit', $contract->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('contracts.destroy', $contract->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this contract?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
