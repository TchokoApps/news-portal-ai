<!DOCTYPE html>
<html lang="{{ getLanguage() }}">

<head>
    <meta charset="utf-8">
    <title>@yield('title', 'News Portal')</title>
    <meta name="description" content="@yield('meta_description', 'Latest multilingual news updates')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('frontend/assets/css/styles.css') }}" rel="stylesheet">
</head>

<body>

    <!-- Header news -->
    <header class="bg-light">
        @include('frontend.home-components.header-topbar')
        @include('frontend.home-components.header-navbar')
        @include('frontend.home-components.header-sidebar-modal')
    </header>
    <!-- End Header news -->

    <main>
        @yield('content')
    </main>

    @include('frontend.home-components.footer')

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Handle language change via dropdown
            $('#siteLanguage').on('change', function() {
                const selectedLanguage = $(this).val();

                $.ajax({
                    url: "{{ route('language.change') }}",
                    type: 'GET',
                    data: {
                        language_code: selectedLanguage
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            // Reload page to apply new language
                            window.location.reload();
                        }
                    },
                    error: function(error) {
                        console.error('Language change error:', error);
                    }
                });
            });
        });
    </script>

</body>

</html>
