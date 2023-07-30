@extends('reader.auth.app')
@section('title')
    {{ __('Verification') }}
@endsection
@section('content')
    <form method="POST" action="{{ route('verify', ['token' => $request->route('token'), 'name' => $request->route('name')]) }}" class="needs-validation" novalidate>
        @csrf
        @honeypot
        <div class="h3 mb-3 fw-normal text-center">{{ __('Verify your number!') }}</div>

        @if (session('status'))
            <div class="alert alert-success text-success-emphasis mb-3" role="alert">
                {{ session('status') }}
            </div>
        @elseif (session('success'))
            <div class="alert alert-success text-success-emphasis mb-3" role="alert">
                {{ session('success') }}
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger text-danger-emphasis mb-3" role="alert">
                <form action="{{ route('resend', ['token' => $request->route('token'), 'name' => $request->route('name')]) }}" method="POST" id="resendCode">
                    @csrf
                    @method('POST')
                    @honeypot
                </form>
                {{ session('error') }} <a href="javascript:void(0);" onclick="$.preventDefault(); alert(); $('form#resendCode').submit();" class="text-danger-emphasis">Try resend!</a>
            </div>
        @endif

        <input type="hidden" name="token" value="{{ $request->route('token') }}" />
        @if($request->has('name'))
            <input type="hidden" name="name" value="{{ $request->name }}" />
        @endif
        <input type="hidden" name="token" value="{{ $request->route('token') }}" />

        <!-- Phone number -->
        <div class="mb-3">
            <label class="form-label fw-bold" for="phone">{{ __('Phone number') }} <span class="text-danger">*</span></label>
            <input type="text"
                   class="mb-3 form-control @error('phone') is-invalid @enderror"
                   id="phone"
                   name="phone"
                   value="{{ $phone }}"
                   placeholder="Your phone..."
                   required
                   readonly />
            @error('phone')
            <div class="invalid-feedback mb-3">
                {{ $message }}
            </div>
            @enderror

            <!-- Verification code -->
            <div class="mb-3">
                <label class="form-label fw-bold" for="phone">{{ __('Verification code') }} <span class="text-danger">*</span></label>
                <input type="text"
                       class="form-control @error('code') is-invalid @enderror"
                       id="code"
                       name="code"
                       value="{{ old('Verification code') }}"
                       placeholder="Your phone..."
                       required
                       autofocus
                       autocomplete="username" />
                @error('code')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
            </div>
        </div>

        <div>
            <button type="submit" class="btn btn-primary w-100 mb-3">Verify</button>
        </div>
    </form>
    <div>
        <form action="{{ route('resend', ['token' => $request->route('token'), 'name' => $request->route('name')]) }}" method="POST" id="resendCode">
            @csrf
            @method('POST')
            @honeypot
            <input type="hidden" name="phone" value="{{ $phone }}">
            <button type="submit" class="btn btn-outline-primary w-100">Resend</button>
        </form>
    </div>
@endsection
