@extends('layout.app')

@section('title')
register
@endsection

@section('content')
<div class="auth">
    <div class="card auth-card">
        <div class="card-body">
            <h5 class="card-title text-center">Register</h5>

            <form action="{{ url('register_post') }}" method="post">
                @csrf
                <div class="form-group mb-3">
                    <label>Nama</label>
                    <input type="text" name="nama" class="form-control" value="{{ old('nama') }}">

                    @error("nama")
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <label>Hak Access</label>
                    <select class="form-control" name="role" value="{{ old('role') }}">
                        <option value="">----</option>
                        <option value="admin">Admin</option>
                        <option value="member">Member</option>
                    </select>

                    @error("role")
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
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
                <div class="form-group mb-3">
                    <label>Konfirmasi Password</label>
                    <input type="password" name="konfirmasi_password" class="form-control" value="{{ old('konfirmasi_password') }}">

                    @error("konfirmasi_password")
                    <div class="form-text text-danger">
                        {{ $message }}
                    </div>
                    @enderror
                </div>
                <div class="d-flex justify-content-between">
                    <a href="/" class="card-link text-center">Login</a>
                    <button type="submit" class="btn btn-sm btn-primary">Register</button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection