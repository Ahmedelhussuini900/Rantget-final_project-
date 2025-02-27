@extends('layout.master')

@section('content')

    <div class="container mt-5">
        <h1>All Properties</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Create Property Button -->
        <div class="mb-3">
            <a href="{{ route('properties.create') }}" class="btn btn-primary">Create New Property</a>
        </div>

        <!-- Properties Table -->
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Price</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($properties as $property)
                    <tr>
                        <td>{{ $property->id }}</td>
                        <td>{{ $property->title }}</td>
                        <td>{{ $property->description }}</td>
                        <td>
                            @if($property->image && Storage::disk('public')->exists($property->image))
                                <img src="{{ asset('storage/' . $property->image) }}" alt="Property Image" class="img-fluid" style="max-width: 100px;">
                            @else
                                No Image Available
                            @endif
                        </td>

                        <td>{{ $property->price }}</td>
                        <td>{{ ucfirst($property->status) }}</td>
                        <td>
                            <a href="{{ route('properties.show', $property->id) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('properties.edit', $property->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('properties.destroy', $property->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this property?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
