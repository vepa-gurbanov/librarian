@extends('reader.auth.app')
@section('title')
    {{ __('Login') }}
@endsection
@section('content')
    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
        @csrf
        @honeypot
        <h1 class="h3 mb-3 fw-normal text-center">{{ __('Welcome back!') }}</h1>

        <!-- Phone number -->
        <div class="mb-3">
            <label class="form-label fw-bold" for="phone">{{ __('Phone number') }} <span class="text-danger">*</span></label>
            <input type="text"
                   class="form-control @error('phone') is-invalid @enderror"
                   id="phone"
                   name="phone"
                   value="{{ old('phone') }}"
                   placeholder="Phone number..."
                   required
                   autofocus
                   autocomplete="username" />
            @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-100">Get verification code</button>
        </div>

    </form>
@endsection
