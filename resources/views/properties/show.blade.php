@extends('layout.master')

@section('content')

<div class="container mt-5">
    <h1>{{ $property->title }}</h1>
    <p><strong>Description:</strong> {{ $property->description }}</p>
    <p><strong>Location:</strong> {{ $property->location }}</p>
    <p><strong>Price:</strong> ${{ $property->price }}</p>
    <p><strong>Status:</strong> {{ ucfirst($property->status) }}</p>

    <h3>Property Image</h3>
    <div>
        @if($property->image)
            <img src="{{ asset('storage/' . $property->image) }}" alt="Property Image" class="img-fluid rounded mb-3">
        @else
            <p>No Image Available</p>
        @endif
    </div>

    <a href="{{ route('properties.index') }}" class="btn btn-secondary">Back to List</a>
</div>

@endsection
