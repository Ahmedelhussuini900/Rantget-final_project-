@extends('layout.master')

@section('content')

<div class="container mt-5">
    <h1>My Rented Properties</h1>

    @if($properties->isEmpty()) {{-- تأكد أن `$properties` هو Collection --}}
        <p class="text-center">You have no rented properties.</p>
    @else
        @foreach($properties as $property) {{-- استخدم `$properties` بصيغة الجمع --}}
            <div class="card mb-3">
                <img src="{{ asset('storage/' . $property->image) }}" class="card-img-top" alt="Property Image">
                <div class="card-body">
                    <h5 class="card-title">{{ $property->title }}</h5>
                    <p class="card-text">{{ $property->description }}</p>
                    <p class="card-text"><strong>Price:</strong> {{ number_format($property->price, 2) }} EGP</p>
                    <p><strong>Status:</strong> {{ $property->status ?? 'Not Available' }}</p>

                    <a href="{{ route('dashboard.renter') }}" class="btn btn-secondary">Back</a>

                    @if(auth()->user()->rentedproperties()->where('property_id', $property->id)->exists())
                        {{-- <a href="{{ route('payments.history', ['property_id' => $property->id]) }}" class="btn btn-primary">Payment History</a> --}}
                    @endif
                </div>
            </div>


        @endforeach
    @endif
{{-- @dd($months) --}}
    @if ($months['status'] != 'paid')
                            <a href="{{ route('payments.create', ['contractId' => $contract->id, 'month' => $month['number'], 'year' => $month['year']]) }}" class="btn btn-primary">
                                Pay Now 💳
                            </a>
                        @else
                            <button class="btn btn-light" disabled>Paid</button>
                        @endif
</div>


@endsection
