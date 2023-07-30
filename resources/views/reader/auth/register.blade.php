@extends('reader.auth.app')
@section('title')
    {{ __('Register') }}
@endsection
@section('content')
    <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
        @csrf
        @honeypot
        <div class="h3 mb-3 fw-normal text-center">{{ __('You\'re welcome!') }}</div>

        <!-- Name -->
            <label class="form-label fw-bold" for="name">{{ __('Name') }} <span class="text-danger">*</span></label>
            <input type="text"
                   class="mb-3 form-control @error('name') is-invalid @enderror"
                   id="name"
                   name="name"
                   value="{{ old('name') }}"
                   required
                   autofocus
            @error('name')
            <div class="invalid-feedback mb-3">
                {{ $message }}
            </div>
            @enderror

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
                   autocomplete="username" />
            @error('phone')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary w-100">Get verification code</button>
        </div>
    </form>
@endsection
