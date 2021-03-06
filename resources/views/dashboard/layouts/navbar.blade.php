<nav class="navbar navbar-expand-lg navbar-transparent  bg-primary  navbar-absolute">
    <div class="container-fluid">
        <div class="navbar-wrapper">
            <div class="navbar-toggle">
                <button type="button" class="navbar-toggler">
                    <span class="navbar-toggler-bar bar1"></span>
                    <span class="navbar-toggler-bar bar2"></span>
                    <span class="navbar-toggler-bar bar3"></span>
                </button>
            </div>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation"
            aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="userWaitingNotification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                      <i class="now-ui-icons ui-1_bell-53"></i>
                      @if (count($usersWaitingNotification) > 0)
                        <sup>
                            <span class="badge badge-danger">{{ count($usersWaitingNotification)}}</span>
                        </sup>
                      @endif
                      <p>
                        <span class="d-lg-none d-md-block">User Menunggu</span>
                      </p>
                    </a>
                    @if (count($usersWaitingNotification) > 0)
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userWaitingNotification">
                            @foreach ($usersWaitingNotification as $user)
                                <a class="dropdown-item" href="#">{{ $user->name}}</a>
                            @endforeach
                        </div>
                    @endif
                  </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <i class="now-ui-icons users_single-02"></i>
                        <p>
                            <span class="d-lg-none d-md-block">Account</span>
                        </p>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <a href="{{ route('admin.edit', Auth::user()->id)}}" class="dropdown-item">Profil</a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                Logout
                            </button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</nav>
