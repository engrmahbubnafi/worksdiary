<x-guest-layout>
    <x-slot name="title">
        Forgot Password
    </x-slot>

    <body id="kt_body" class="bg-body">
        <div class="d-flex flex-column flex-root">
            <div
                class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
                <div class="d-flex flex-center flex-column flex-column-fluid p-10 pb-lg-20">
                    <a href="{{ route('home') }}" class="mb-12">
                        <img alt="Logo" src="{{ asset('assets/media/logos/work-diary-logo.png') }}" class="h-40px" />
                    </a>

                    @if (Session::has('status'))
                        <div class="alert alert-success">
                            {{ Session::get('status') }}
                            @php
                                Session::forget('status');
                            @endphp
                        </div>
                    @endif

                    <div class="w-lg-500px bg-body rounded shadow-sm p-10 p-lg-15 mx-auto">
                        <form class="form w-100" method="POST" action="{{ route('password.email') }}"
                            novalidate="novalidate" id="kt_password_reset_form">
                            @csrf

                            <div class="text-center mb-10">
                                <h1 class="text-dark mb-3">Forgot Password ?</h1>
                                <div class="text-gray-400 fw-bold fs-4">Enter your email to reset your password.</div>
                            </div>

                            <div class="fv-row mb-10">
                                <x-label class="form-label fw-bolder text-gray-900 fs-6" :value="__('Email')" />
                                <x-input id="email" class="form-control form-control-solid" type="email"
                                    name="email" :value="old('email')" required autofocus />
                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="d-flex flex-wrap pb-lg-0">
                                <x-button class="btn btn-lg btn-primary fw-bolder me-4">
                                    {{ __('Email Password Reset Link') }}
                                </x-button>
                                <a href="{{ route('login') }}" class="btn btn-lg btn-light-primary fw-bolder">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script>
            var hostUrl = "assets/";
        </script>
        <script src="assets/plugins/global/plugins.bundle.js"></script>
        <script src="assets/js/scripts.bundle.js"></script>
    </body>
</x-guest-layout>
