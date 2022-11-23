<x-guest-layout>
    <x-slot name="title">
        Login
    </x-slot>

    <body id="kt_body" class="bg-body">
        <div class="d-flex flex-column flex-root">
            <div
                class="d-flex flex-column flex-column-fluid bgi-position-y-bottom position-x-center bgi-no-repeat bgi-size-contain bgi-attachment-fixed">
                <div class="d-flex flex-center flex-column flex-column-fluid pb-lg-20 p-10">
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

                    <div class="w-lg-500px bg-body p-lg-15 mx-auto rounded p-10 shadow-sm">
                        <form class="form w-100" method="POST" action="{{ route('login') }}" id="kt_sign_in_form">
                            @csrf

                            <div class="mb-10 text-center">
                                <h1 class="text-dark mb-3">Login to Admin Panel</h1>
                            </div>

                            <div class="fv-row mb-10">
                                <label class="form-label fs-6 fw-bolder text-dark">Email</label>
                                <input class="form-control form-control-lg form-control-solid" type="text"
                                    name="email" autocomplete="off" />

                                @if ($errors->has('email'))
                                    <span class="text-danger">{{ $errors->first('email') }}</span>
                                @endif
                            </div>

                            <div class="fv-row mb-10">
                                <div class="d-flex flex-stack mb-2">
                                    <label class="form-label fw-bolder text-dark fs-6 mb-0">Password</label>
                                    <a href="{{ route('password.request') }}" class="link-primary fs-6 fw-bolder">Forgot
                                        Password ?</a>
                                </div>

                                <input class="form-control form-control-lg form-control-solid" type="password"
                                    name="password" autocomplete="off" />

                                @if ($errors->has('password'))
                                    <span class="text-danger">{{ $errors->first('password') }}</span>
                                @endif
                            </div>

                            <div>
                                <x-button class="btn btn-lg btn-primary fw-bolder me-4">
                                    {{ __('Login') }}
                                </x-button>
                                {{-- <button type="submit" id="kt_sign_in_submit" class="btn btn-lg btn-primary w-100 mb-5">
                                    <span class="indicator-label">Continue</span>
                                    <span class="indicator-progress">Please wait...
                                        <span class="spinner-border spinner-border-sm ms-2 align-middle"></span></span>
                                </button> --}}
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
    </x-guest-layouts>
