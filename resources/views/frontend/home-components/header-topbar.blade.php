<!-- Navbar  Top-->
<div class="topbar d-none d-sm-block">
    <div class="container ">
        <div class="row">
            <div class="col-sm-6 col-md-8">
                <div class="topbar-left topbar-right d-flex">

                    <ul class="topbar-sosmed p-0">
                        <li>
                            <a href="#"><i class="fa fa-facebook"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-twitter"></i></a>
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-instagram"></i></a>
                        </li>
                    </ul>
                    <div class="topbar-text">
                        Friday, May 19, 2023
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="list-unstyled topbar-right d-flex align-items-center justify-content-end">
                    <div class="topbar_language">
                        <select id="siteLanguage">
                            @foreach(getActiveLanguages() as $language)
                                <option value="{{ $language->code }}" @selected(getLanguage() === $language->code)>
                                    {{ $language->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <ul class="topbar-link">
                        <li><a href="{{ route('login') }}">Login</a></li>
                        <li><a href="{{ route('register') }}">Register</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Navbar Top  -->
