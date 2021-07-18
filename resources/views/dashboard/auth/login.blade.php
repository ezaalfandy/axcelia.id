<!DOCTYPE html>
<html lang="en">

<head>
    @include('dashboard.layouts.head')
</head>

<body class="sidebar-mini">
    <div class="wrapper wrapper-full-page ">
        <div class="full-page login-page section-image" filter-color="primary"
            data-image="{{ asset('dashboard') }}/img/login-bg.jpg">
            <div class="content">
                <div class="container">
                    <div class="col-md-4 ml-auto mr-auto">
                        @include('dashboard.layouts.notification')
                        <form class="form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="card card-login card-plain">
                                <div class="card-header ">
                                    <div class="logo-container">
                                        <img src="{{ asset('dashboard') }}/img/logo-axcelia.png" alt="">
                                    </div>
                                </div>
                                <div class="card-body ">
                                    <div class="input-group no-border form-control-lg">
                                        <span class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons users_circle-08"></i>
                                            </div>
                                        </span>
                                        <input type="text" name="email" class="form-control" placeholder="email" required="true">
                                    </div>
                                    <div class="input-group no-border form-control-lg">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="now-ui-icons text_caps-small"></i>
                                            </div>
                                        </div>
                                        <input type="password" name="password" placeholder="password" class="form-control">
                                    </div>
                                </div>
                                <div class="card-footer ">
                                    <button type="submit" class="btn btn-primary btn-round btn-lg btn-block mb-3">Login</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('dashboard')}}/js/app.js"></script>
    <script>
        $(document).ready(function() {
            app.checkFullPageBackgroundImage();
        });
    </script>
</body>

</html>
