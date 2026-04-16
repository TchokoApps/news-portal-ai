<!DOCTYPE html>
<html lang="">

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

</body>

</html>
