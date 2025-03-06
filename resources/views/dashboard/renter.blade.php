@extends('layout.master')

@section('content')
@if(auth()->check())
    <div class="text-center my-4">
        <h1>Welcome, {{ auth()->user()->fullname }}!</h1>
        <p>Your rented properties:</p>
    </div>

    @if($rentedProperties->isEmpty())
        <p class="text-center">You have not rented any properties yet.</p>
    @else
        <div class="slider-container">
            <div class="slider">
                @foreach($rentedProperties as $property)
                    <div class="slider-item">
                        <a href="{{ route('properties.show', $property->id) }}">
                            <img src="{{ asset('storage/' . $property->image) }}" alt="{{ $property->title }}">
                            <div class="property-info">
                                <h5>{{ $property->title }}</h5>
                                <p>Location: {{ $property->location ?? 'N/A' }}</p>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
            <button class="prev" onclick="moveSlider(-1)">&#10094;</button>
            <button class="next" onclick="moveSlider(1)">&#10095;</button>
        </div>
    @endif
@else
    <p class="text-danger text-center">You must be logged in to view this page.</p>
    <div class="text-center">
        <a href="{{ route('login') }}" class="btn btn-secondary">Login</a>
    </div>
@endif
@endsection

@push('styles')
<style>
    .slider-container {
        position: relative;
        overflow: hidden;
        width: 80%;
        max-width: 1000px;
        margin: auto;
    }
    .slider {
        display: flex;
        transition: transform 0.5s ease-in-out;
    }
    .slider-item {
        min-width: 20%;
        max-width: 20%;
        flex: 0 0 auto;
        box-sizing: border-box;
        padding: 10px;
        text-align: center;
    }
    .slider-item img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        border-radius: 10px;
    }
    .property-info {
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px;
        position: relative;
        margin-top: -30px;
    }
    .prev, .next {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(0,0,0,0.5);
        color: white;
        border: none;
        padding: 10px;
        cursor: pointer;
        font-size: 20px;
    }
    .prev { left: 10px; }
    .next { right: 10px; }
</style>
@endpush

@push('scripts')
<script>
    let currentIndex = 0;

    function moveSlider(step) {
        const slider = document.querySelector('.slider');
        const items = document.querySelectorAll('.slider-item');
        const totalItems = items.length;
        const visibleItems = 5;

        currentIndex += step;

        if (currentIndex < 0) currentIndex = totalItems - visibleItems;
        if (currentIndex > totalItems - visibleItems) currentIndex = 0;

        slider.style.transform = `translateX(-${currentIndex * (100 / visibleItems)}%)`;
    }
</script>
@endpush
