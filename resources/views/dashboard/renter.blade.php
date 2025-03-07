@extends('layout.master')

@section('content')
    @if(auth()->check())
        <div class="text-center my-4">
            <h1>Welcome, {{ auth()->user()->fullname }}!</h1>
            <p>Here are your rented properties.</p>
        </div>

        <h2 class="text-center my-4">My Rented Properties</h2>

        @if($rentedproperties->isEmpty())
            <p class="text-center">No rented properties found.</p>
        @else
            <div class="slider-container">
                <div class="slider">
                    @foreach($rentedproperties as $property)
                        <div class="slider-item">
                            <img src="{{ Storage::url($property->image) }}" alt="{{ $property->title }}">
                            <div class="property-info">
                                <h5>{{ $property->title }}</h5>
                            </div>
                            <a href="{{ route('rented-properties', ['property' => $property->id]) }}" class="btn btn-primary mt-2">View Details</a>
                        </div>
                    @endforeach
                </div>

                <button class="prev" onclick="moveSlider(-1)">&#10094;</button>
                <button class="next" onclick="moveSlider(1)">&#10095;</button>
            </div>
        @endif
    @else
        <p class="text-danger">You must be logged in to view this page.</p>
        <a href="{{ route('auth.signin') }}" class="btn btn-secondary">Login</a>
    @endif
@endsection


<style>
   .slider-container {
    position: relative;
    overflow: hidden;
    width: 80%; /* الحفاظ على عرض السلايدر */
    max-width: 1000px; /* تحديد الحد الأقصى */
    margin: auto;
}
.slider {
    display: flex;
    flex-wrap: nowrap;
    transition: transform 0.5s ease-in-out;
}
.slider-item {
    min-width: 20%; /* كل عنصر يأخذ 20% من عرض السلايدر ليتناسب مع 5 عناصر */
    max-width: 20%; /* يمنع العناصر من التمدد */
    flex: 0 0 auto;
    box-sizing: border-box;
    padding: 10px;
    text-align: center;
}
.slider-item img {
    width: 100%; /* الصورة تمتد داخل العنصر */
    height: 180px; /* الحفاظ على نفس الارتفاع */
    object-fit: cover;
    border-radius: 10px;
}

.property-info {
        background: rgba(0, 0, 0, 0.7);
        color: white;
        padding: 10px;
        margin-top: -30px;
        position: relative;
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

<script>
    let index = 0;
    function moveSlider(step) {
        const slider = document.querySelector('.slider');
        const items = document.querySelectorAll('.slider-item');
        const totalItems = items.length;
        const visibleItems = 5; // عدد العناصر الظاهرة في السلايدر

        index += step;
        if (index < 0) index = totalItems - visibleItems;
        if (index > totalItems - visibleItems) index = 0;

        slider.style.transform = translateX(-${index * (100 / visibleItems)}%);
    }
</script>
