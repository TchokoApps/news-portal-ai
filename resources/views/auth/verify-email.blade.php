<x-admin-guest-layout>
    <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">

            <!-- Verify Email Brand -->
            <div class="login-brand">
                <a href="{{ route('login') }}">
                    <img src="{{ asset('admin/assets/img/stisla-fill.svg') }}" alt="logo" width="100" class="shadow-light rounded-circle">
                </a>
            </div>

            <!-- Status Messages -->
            @if (session('status') == 'verification-link-sent')
                <div class="alert alert-success alert-dismissible show" role="alert">
                    <div class="alert-body">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <!-- Verify Email Card -->
            <div class="card card-primary">
                <div class="card-header">
                    <h4>{{ __('Verify Email Address') }}</h4>
                </div>

                <div class="card-body">
                    <p class="text-muted mb-4">
                        {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                    </p>

                    <div class="row g-2">
                        <div class="col-6">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <button type="submit" class="btn btn-primary btn-block w-100">
                                    {{ __('Resend Verification Email') }}
                                </button>
                            </form>
                        </div>
                        <div class="col-6">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-secondary btn-block w-100">
                                    {{ __('Log Out') }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Footer -->
            <div class="mt-5 text-muted text-center">
                <small>&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}</small>
            </div>

        </div>
    </div>
</x-admin-guest-layout>
