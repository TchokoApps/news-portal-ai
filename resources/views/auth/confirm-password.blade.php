<x-admin-guest-layout>
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

            <!-- Confirm Password Brand -->
            <div class="login-brand">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('admin/assets/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
                </a>
            </div>

            <!-- Errors -->
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

            <!-- Confirm Password Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('Confirm Password') }}</h4>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-4">
                        {{ __('This is a secure area of the application. Please confirm your password before continuing.') }}
                    </p>

                    <form method="POST" action="{{ route('password.confirm') }}" class="needs-validation" novalidate>
                        @csrf

                        <!-- Password -->
                        <div class="form-group">
                            <label for="password">{{ __('Password') }}</label>
                            <input
                                id="password"
                                type="password"
                                class="form-control @error('password') is-invalid @enderror"
                                name="password"
                                required
                                autocomplete="current-password"
                            >
                            @error('password')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Submit Button -->
                        <div class="form-group">
                            <button
                                type="submit"
                                class="btn btn-primary btn-lg btn-block"
                            >
                                {{ __('Confirm') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-5 text-muted text-center">
                <small>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</small>
            </div>

        </div>
    </div>
</x-admin-guest-layout>
