@extends('layout.master')

@section('content')
    @if(auth()->check())
        <h1>Welcome, Owner {{ auth()->user()->fullname }}!</h1>
        <p>You have access to manage properties and renters.</p>

        <div class="mb-3">
            <a href="{{ route('properties.create') }}" class="btn btn-primary">Create New Property</a>
        </div>
    @else
        <p class="text-danger">You must be logged in to view this page.</p>
        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
    @endif

    <div class="mb-3">
        <a href="{{ url()->previous() }}" class="btn btn-secondary">Back</a>
    </div>

@endsection
