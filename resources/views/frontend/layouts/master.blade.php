<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <title>Top News HTML template </title>
    <meta name="description" content="">
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

    <!-- Main Content Sections -->
    @include('frontend.home-components.trending-carousel')

    @include('frontend.home-components.popular-news-header')

    @include('frontend.home-components.large-advertisement-banner')

    @include('frontend.home-components.recent-posts-main')

    @include('frontend.home-components.technology-carousel')

    <!-- Lifestyle Section -->
    <div class="mt-4">
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    @include('frontend.home-components.lifestyle-section')

                    @include('frontend.home-components.small-advertisement-banner')

                    @include('frontend.home-components.technology-grid-imageleft')
                </div>

                <div class="col-md-4">
                    <div class="sticky-top">
                        @include('frontend.home-components.sidebar-latest-posts')

                        @include('frontend.home-components.sidebar-social-media')

                        @include('frontend.home-components.sidebar-tags')

                        @include('frontend.home-components.sidebar-advertisement')

                        @include('frontend.home-components.sidebar-newsletter')
                    </div>
                </div>
            </div>

            <div class="mx-auto">
                @include('frontend.home-components.pagination')
            </div>

            <div class="clearfix"></div>
        </div>
    </div>
    <!-- End Lifestyle Section -->

    @include('frontend.home-components.footer')

    <a href="javascript:" id="return-to-top"><i class="fa fa-chevron-up"></i></a>

    <script type="text/javascript" src="{{ asset('frontend/assets/js/index.bundle.js') }}"></script>

</body>

</html>
