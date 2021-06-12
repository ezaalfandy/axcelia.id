<!DOCTYPE html>
<html lang="en">

<head>
    @include('front.layouts.head')
</head>

<body class="login-page sidebar-collapse">

    <div class="page-header header-filter" filter-color="black">
        <div class="page-header-image" style="background-image:url({{ asset('front/img/login-bg.jpg') }})"></div>
        <div class="content">
            <div class="container">
                @include('dashboard.layouts.notification')
                <div class="col-md-5 ml-auto mr-auto">
                    <div class="card card-login card-plain">
                        <form class="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="card-header text-center">
                                <div class="logo-container">
                                    <img src="{{ asset('front/img/logo-joemen.png') }}" alt="">
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="input-group no-border input-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="now-ui-icons ui-1_email-85"></i></span>
                                    </div>
                                    <input type="text" name="email" class="form-control" placeholder="Email">
                                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="input-group no-border input-lg">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i
                                                class="now-ui-icons ui-1_lock-circle-open"></i></span>
                                    </div>
                                    <input type="password" name="password" class="form-control" placeholder="password">
                                </div>
                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary btn-block">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src=" {{ asset('front/js/app.js') }}" type="text/javascript"></script>
</body>

</html>
