@extends('layout.master')

@section('content')

<div class="container mt-5">
    <h1>Edit Property</h1>

    <form action="{{ route('properties.update', $property->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $property->title }}" required>
        </div>

        <div class="form-group">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" required>{{ $property->description }}</textarea>
        </div>

        <div class="form-group">
            <label for="location">Location</label>
            <input type="text" name="location" id="location" class="form-control" value="{{ $property->location }}" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" class="form-control" value="{{ $property->price }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control" required>
                <option value="available" {{ $property->status == 'available' ? 'selected' : '' }}>Available</option>
                <option value="reserved" {{ $property->status == 'reserved' ? 'selected' : '' }}>Reserved</option>
                <option value="unavailable" {{ $property->status == 'unavailable' ? 'selected' : '' }}>Unavailable</option>
                <option value="rent" {{ $property->status == 'rent' ? 'selected' : '' }}>For Rent</option>
            </select>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" class="form-control">
            @if($property->image)
                <p>Current Image: <img src="{{ asset('storage/' . $property->image) }}" alt="Current Image" class="img-fluid" style="max-width: 100px;"></p>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Update Property</button>
    </form>

    <div class="mt-3">
        <a href="{{ route('properties.index') }}" class="btn btn-secondary">Back to Properties</a>
    </div>
</div>

@endsection
