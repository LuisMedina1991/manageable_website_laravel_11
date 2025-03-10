@extends('layouts.main_web')

@section('title',__('Login'))

@section('content')

<div class="d-flex justify-content-center align-items-center min-vh-100 login-container">
    <div class="card shadow login-card">
        <div class="card-header text-center text-white login-header">
            <span class="fs-1 fw-bold">{{ __('Login') }}</span>
        </div>
        <div class="card-body">
            <form action="{{ route('login') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-12">
                        <div class="form-floating">
                            <input autofocus type="email" name="email" id="email" class="form-control" placeholder="{{ __('Email') }}" value="{{ old('email') }}"/>
                            <label for="email" class="text-uppercase">{{ __('Email') }}</label>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="form-floating">
                            <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Password') }}"/>
                            <label for="password" class="text-uppercase">{{ __('Password') }}</label>
                            @error('password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn w-100 text-white fs-5 fw-semibold login-submit-button">
                            {{ __('Sign in') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection