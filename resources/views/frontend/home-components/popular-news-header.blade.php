<!-- Popular news  header-->
<section>
    <div class="popular__news-header">
        <div class="container">
            <div class="row no-gutters">
                <div class="col-md-8 ">
                    <div class="card__post-carousel">
                        <div class="item">
                            <!-- Post Article -->
                            <div class="card__post">
                                <div class="card__post__body">
                                    <a href="#">
                                        <img src="{{ asset('frontend/assets/images/newsimage1.png') }}" class="img-fluid" alt="">
                                    </a>
                                    <div class="card__post__content bg__post-cover">
                                        <div class="card__post__category">
                                            covid-19
                                        </div>
                                        <div class="card__post__title">
                                            <h2>
                                                <a href="#">
                                                    Global solidarity to fight COVID-19, and indonesia stay safe and
                                                    health
                                                </a>
                                            </h2>
                                        </div>
                                        <div class="card__post__author-info">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="#">
                                                        by david hall
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span>
                                                        Descember 09, 2016
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>


                            </div>
                        </div>
                        <div class="item">
                            <!-- Post Article -->
                            <div class="card__post">
                                <div class="card__post__body">
                                    <a href="#">
                                        <img src="{{ asset('frontend/assets/images/newsimage2.png') }}" class="img-fluid" alt="">
                                    </a>
                                    <div class="card__post__content bg__post-cover">
                                        <div class="card__post__category">
                                            covid-19
                                        </div>
                                        <div class="card__post__title">
                                            <h2>
                                                <a href="#">
                                                    Global solidarity to fight COVID-19, and indonesia stay safe and
                                                    health
                                                </a>
                                            </h2>
                                        </div>
                                        <div class="card__post__author-info">
                                            <ul class="list-inline">
                                                <li class="list-inline-item">
                                                    <a href="#">
                                                        by david hall
                                                    </a>
                                                </li>
                                                <li class="list-inline-item">
                                                    <span>
                                                        Descember 09, 2016
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="popular__news-right">
                        <!-- Post Article -->
                        <div class="card__post ">
                            <div class="card__post__body card__post__transition">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/newsimage3.png') }} "class="img-fluid" alt="">
                                </a>
                                <div class="card__post__content bg__post-cover">
                                    <div class="card__post__category">
                                        politics
                                    </div>
                                    <div class="card__post__title">
                                        <h5>
                                            <a href="#">
                                                Barack Obama and Family Visit borobudur temple enjoy holiday
                                                indonesia.</a>
                                        </h5>
                                    </div>
                                    <div class="card__post__author-info">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="#">
                                                    by david hall
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    Descember 09, 2016
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!-- Post Article -->
                        <div class="card__post ">
                            <div class="card__post__body card__post__transition">
                                <a href="#">
                                    <img src="{{ asset('frontend/assets/images/newsimage4.png') }} "class="img-fluid" alt="">
                                </a>
                                <div class="card__post__content bg__post-cover">
                                    <div class="card__post__category">
                                        politics
                                    </div>
                                    <div class="card__post__title">
                                        <h5>
                                            <a href="#">
                                                Barack Obama and Family Visit borobudur temple enjoy holiday
                                                indonesia.</a>
                                        </h5>
                                    </div>
                                    <div class="card__post__author-info">
                                        <ul class="list-inline">
                                            <li class="list-inline-item">
                                                <a href="#">
                                                    by david hall
                                                </a>
                                            </li>
                                            <li class="list-inline-item">
                                                <span>
                                                    Descember 09, 2016
                                                </span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End Popular news header-->

    <!-- Popular news carousel -->
    @include('frontend.home-components.popular-news-carousel')
    <!-- End Popular news carousel -->
</section>
<!-- End Popular news -->
