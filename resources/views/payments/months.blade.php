@extends('layout.master')

@section('content')
<div class="container">
    <h2 class="mb-4">Payment Status for Contract #{{ $contract->id }}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Month</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($months as $month)
                <tr>
                    <td>{{ $month['name'] }}</td>
                    <td>
                        @if ($month['status'] == 'paid')
                            <span class="badge bg-success">Paid ✅</span>
                        @elseif ($month['status'] == 'late')
                            <span class="badge bg-danger">Late 🔴</span>
                        @else
                            <span class="badge bg-secondary">Unpaid ⚪</span>
                        @endif
                    </td>
                    <td>
                        @if ($month['status'] != 'paid')
                            <a href="{{ route('payments.create', ['contractId' => $contract->id, 'month' => $month['number'], 'year' => $month['year']]) }}" class="btn btn-primary">
                                Pay Now 💳
                            </a>
                        @else
                            <button class="btn btn-light" disabled>Paid</button>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
