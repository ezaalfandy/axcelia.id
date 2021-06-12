<nav class="navbar navbar-expand-lg bg-white fixed-top">
    <div class="container">
        <div class="navbar-translate">
            <a class="navbar-brand" href="https://demos.creative-tim.com/now-ui-kit-pro/index.html" rel="tooltip"
                title="Designed by Invision. Coded by Creative Tim" data-placement="bottom" target="_blank">
                {{ Auth::user()}}
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
                aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-bar top-bar"></span>
                <span class="navbar-toggler-bar middle-bar"></span>
                <span class="navbar-toggler-bar bottom-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" data-nav-image="{{ asset('front/img/sidebar.jpg') }}" data-color="primary">
            <ul class="navbar-nav ml-auto">
                @guest('clients')
                    <li class="nav-item">
                        <a class="nav-link btn btn-neutral" href="{{ route('register') }}">
                            <p>Daftar</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary" href="{{ route('login') }}">
                            <p>Login</p>
                        </a>
                    </li>
                @endguest



                @auth('clients')
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="now-ui-icons shopping_cart-simple"></i>
                            Keranjang &nbsp;
                            <span class="badge badge-primary">2</span>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-expanded="false">
                            <i class="now-ui-icons users_single-02"></i>
                            Profile
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            <a class="dropdown-item" href="../examples/about-us.html">
                                Akun
                            </a>
                            <a class="dropdown-item" href="../examples/about-us.html">
                                Riwayat Pembelian
                            </a>
                            <a class="dropdown-item" href="../examples/about-us.html">
                                Logout
                            </a>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
