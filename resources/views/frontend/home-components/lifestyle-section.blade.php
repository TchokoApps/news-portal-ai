<!-- Lifestyle section -->
<div class="mt-4">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <aside class="wrapper__list__article mb-0">
                    <h4 class="border_section">lifestyle</h4>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-4">
                                <!-- Post Article -->
                                <div class="article__entry">
                                    <div class="article__image">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/images/newsimage1.png') }} "alt="" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="article__content">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span class="text-primary">
                                                    by david hall
                                                </span>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    descember 09, 2016
                                                </span>
                                            </li>

                                        </ul>
                                        <h5>
                                            <a href="#">
                                                Maecenas accumsan tortor ut velit pharetra mollis.
                                            </a>
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <!-- Post Article -->
                                <div class="article__entry">
                                    <div class="article__image">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/images/newsimage2.png') }} "alt="" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="article__content">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span class="text-primary">
                                                    by david hall
                                                </span>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    descember 09, 2016
                                                </span>
                                            </li>

                                        </ul>
                                        <h5>
                                            <a href="#">
                                                Maecenas accumsan tortor ut velit pharetra mollis.
                                            </a>
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <!-- Post Article -->
                                <div class="article__entry">
                                    <div class="article__image">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/images/newsimage3.png') }} "alt="" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="article__content">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span class="text-primary">
                                                    by david hall
                                                </span>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    descember 09, 2016
                                                </span>
                                            </li>

                                        </ul>
                                        <h5>
                                            <a href="#">
                                                Maecenas accumsan tortor ut velit pharetra mollis.
                                            </a>
                                        </h5>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-4">
                                <!-- Post Article -->
                                <div class="article__entry">
                                    <div class="article__image">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/images/newsimage4.png') }} "alt="" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="article__content">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span class="text-primary">
                                                    by david hall
                                                </span>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    descember 09, 2016
                                                </span>
                                            </li>

                                        </ul>
                                        <h5>
                                            <a href="#">
                                                Maecenas accumsan tortor ut velit pharetra mollis.
                                            </a>
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <!-- Post Article -->
                                <div class="article__entry">
                                    <div class="article__image">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/images/newsimage6.png') }} "alt="" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="article__content">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span class="text-primary">
                                                    by david hall
                                                </span>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    descember 09, 2016
                                                </span>
                                            </li>

                                        </ul>
                                        <h5>
                                            <a href="#">
                                                Maecenas accumsan tortor ut velit pharetra mollis.
                                            </a>
                                        </h5>

                                    </div>
                                </div>
                            </div>
                            <div class="mb-4">
                                <!-- Post Article -->
                                <div class="article__entry">
                                    <div class="article__image">
                                        <a href="#">
                                            <img src="{{ asset('frontend/assets/images/newsimage6.png') }} "alt="" class="img-fluid">
                                        </a>
                                    </div>
                                    <div class="article__content">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <span class="text-primary">
                                                    by david hall
                                                </span>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    descember 09, 2016
                                                </span>
                                            </li>

                                        </ul>
                                        <h5>
                                            <a href="#">
                                                Maecenas accumsan tortor ut velit pharetra mollis.
                                            </a>
                                        </h5>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </aside>

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
</div>
</section>
<!-- End Popular news category -->
