<x-admin-guest-layout>
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

            <!-- Login Brand -->
            <div class="login-brand">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('admin/assets/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
                </a>
            </div>

            <!-- Session Status -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible show" role="alert">
                    <div class="alert-body">
                        <strong>{{ __('Errors:') }}</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('status'))
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <div class="alert-body">
                        {{ session('status') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Login Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('Admin Login') }}</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Email Address -->
                        <div class="form-group">
                            <label for="email">{{ __('Email Address') }}</label>
                            <input
                                id="email"
                                type="email"
                                class="form-control @error('email') is-invalid @enderror"
                                name="email"
                                value="{{ old('email') }}"
                                tabindex="1"
                                required
                                autofocus
                                autocomplete="username"
                            >
                            @error('email')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if (!$errors->has('email'))
                                <div class="invalid-feedback">
                                    {{ __('Please fill in your email') }}
                                </div>
                            @endif
                        </div>

                        <!-- Password -->
                        <div class="form-group">
                            <div class="d-block">
                                <label for="password" class="control-label">{{ __('Password') }}</label>
                                <div class="float-right">
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-small">
                                            {{ __('Forgot Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                tabindex="2"
                                required
                                autocomplete="current-password"
                            >
                            @error('password')
                                <div class="invalid-feedback d-block">
                                    {{ $message }}
                                </div>
                            @enderror
                            @if (!$errors->has('password'))
                                <div class="invalid-feedback">
                                    {{ __('Please fill in your password') }}
                                </div>
                            @endif
                        </div>

                        <!-- Remember Me -->
                        <div class="form-group">
                            <div class="custom-control custom-checkbox">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    class="custom-control-input"
                                    tabindex="3"
                                    id="remember-me"
                                    {{ old('remember') ? 'checked' : '' }}
                                >
                                <label class="custom-control-label" for="remember-me">
                                    {{ __('Remember Me') }}
                                </label>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg btn-block"
                                tabindex="4"
                            >
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>

                </div>
            </div>

            <!-- Footer -->
            <div class="mt-5 text-muted text-center">
                <small>
                    &copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. {{ __('All rights reserved.') }}
                </small>
            </div>

        </div>
    </div>
</x-admin-guest-layout>
