<!DOCTYPE html>
<html lang="en">

<head>
    @extends('front.layouts.head')
</head>

<body class="sidebar-collapse">
    @extends('front.layouts.navbar')

    <div class="wrapper">
        @yield('main')
        @extends('front.layouts.footer')
    </div>

    <script src=" {{ asset('front/js/app.js') }}" type="text/javascript"></script>

    @stack('js')
</body>

</html>
