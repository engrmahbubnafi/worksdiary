<x-guest-layout>
    <x-slot name="title">
        Reset Password
    </x-slot>

    <x-auth-card>
        <x-slot name="logo">
            <a href="{{ route('home') }}" class="mb-12">
                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
            </a>
        </x-slot>

        @if (Session::has('status'))
            <div class="alert alert-success">
                {{ Session::get('status') }}
                @php
                    Session::forget('status');
                @endphp
            </div>
        @endif

        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mt-4">
                <x-label class="form-label fw-bolder text-gray-900 fs-6" :value="__('Email')" />
                <x-input id="email" class="block mt-1 w-full" type="email" name="email" required />
            </div>
            @if ($errors->has('email'))
                <span class="text-danger" style="color: red !important;">{{ $errors->first('email') }}</span>
            @endif

            <div class="mt-4">
                <x-label class="form-label fw-bolder text-gray-900 fs-6" :value="__('Password')" />
                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            </div>
            @if ($errors->has('password'))
                <span class="text-danger" style="color: red !important;">{{ $errors->first('password') }}</span>
            @endif

            <div class="mt-4">
                <x-label class="form-label fw-bolder text-gray-900 fs-6" :value="__('Confirm Password')" />
                <x-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />
            </div>
            @if ($errors->has('password_confirmation'))
                <span class="text-danger"
                    style="color: red !important;">{{ $errors->first('password_confirmation') }}</span>
            @endif

            <div class="flex items-center mt-4">
                <x-button class="btn btn-lg btn-primary fw-bolder me-4" style="background-color: #009ef7 !important;">
                    {{ __('Reset Password') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
