@extends('layout.master')

@section('title', 'Property Details')

@section('content')

<div class="container mt-5">
    <h1>Property Details</h1>

    <div class="card">
        <div class="card-header">
            <h2>{{ $property->title }}</h2>
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $property->description }}</p>
            <p><strong>Location:</strong> {{ $property->location }}</p>
            <p><strong>Price:</strong> ${{ number_format($property->price, 2) }}</p>
            <p><strong>Status:</strong> {{ ucfirst($property->status) }}</p>

            @if($property->image)
                <p><strong>Image:</strong></p>
                <img src="{{ asset('storage/' . $property->image) }}" alt="Property Image" class="img-fluid" style="max-width: 300px;">
            @else
                <p>No image available</p>
            @endif
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('properties.index') }}" class="btn btn-secondary">Back to Properties</a>
    </div>
</div>

@endsection
