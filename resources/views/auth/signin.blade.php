@extends('layout.master')
@section('my-body')
<form class="form-container" action="/auth/login" method="post">
    @csrf
    <fieldset>
        <legend>Login..</legend>
        <br>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email">{{old('email')}}</input>
        @error('email')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <label for="password">Password:</label>
        <input type="password" id="password" name="password">
        @error('password')
            <div style="color: red;">{{ $message }}</div>
        @enderror

        <button class="btn btn-success">Sign in</button>
    </fieldset>
</form>
@endsection