@extends('layout.app')

@section('title')
login
@endsection

@section('content')
<div class="auth">
    <div class="card auth-card">
        <div class="card-body">
            <h5 class="card-title text-center">Login</h5>

            @if($message = session()->get('message'))
            <div class="alert alert-success" role="alert">
                {{ $message }}
            </div>
            @endif

            @if($error = session()->get('error'))
            <div class="alert alert-danger" role="alert">
                {{ $error }}
            </div>
            @endif

            <form action="{{ url('login_post') }}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" value="{{ old('email') }}">

                    @error("email")
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label>Password</label>
                    <input type="password" name="pass" class="form-control" value="{{ old('pass') }}">

                    @error("pass")
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="register" class="card-link text-center">Register</a>
                    <button type="submit" class="btn btn-sm btn-primary">Login</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection