<!DOCTYPE html>
<html lang="en">

<head>
    @include('dashboard.layouts.head')
</head>

<body class="sidebar-mini">
    <div class="wrapper">
        @include('dashboard.layouts.sidebar')
        <div class="main-panel" id="main-panel">
            @include('dashboard.layouts.navbar')

            <div class="panel-header panel-header-sm">

            </div>
            <div class="content">
                @include('dashboard.layouts.notification')
                @yield('main')
            </div>
        </div>
    </div>
    <script src="{{ asset('dashboard')}}/js/app.js"></script>
    @stack('js')
</body>

</html>
