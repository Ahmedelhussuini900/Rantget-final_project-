@extends('layout.master')

@section('content')
    <div class="container mt-5">
        <h1>Log In..</h1>


        <!-- Form -->
        <form action="/login" method="POST" enctype="multipart/form-data">
            @csrf

        
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" id="email" class="form-control" required value="{{ old('email') }}">
                @error('email')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>


            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" id="password" class="form-control" required minlength="8">
                @error('password')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>




            <button type="submit" class="btn btn-primary">Log in</button>
        </form>
    </div>
@endsection
