@extends('front.layouts.app')

@section('main')
    <div class="main">
        <div class="container">
            <div class="row">
                <div class="col-md-12 mt-5">
                    <div id="carouselExampleIndicators" class="carousel slide mt-5">
                        <ol class="carousel-indicators">
                            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="1" class=""></li>
                            <li data-target="#carouselExampleIndicators" data-slide-to="2" class=""></li>
                        </ol>
                        <div class="carousel-inner" role="listbox">
                            <div class="carousel-item active">
                                <img src="{{ asset('storage/front/') }}/img/bg40.jpg" class="img-fluid" >
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('storage/front/') }}/img/bg40.jpg" class="img-fluid" >
                            </div>
                            <div class="carousel-item">
                                <img src="{{ asset('storage/front/') }}/img/bg40.jpg" class="img-fluid" >
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                            <i class="now-ui-icons arrows-1_minimal-left"></i>
                        </a>
                        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                            <i class="now-ui-icons arrows-1_minimal-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="section">
            <div class="container">
                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-lg-3 col-md-4 col-6">
                            @include('front.components.product_card', $product)
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        if ($('.navbar[color-on-scroll]').length != 0) {
            nowuiKit.checkScrollForTransparentNavbar();
            $(window).on('scroll', nowuiKit.checkScrollForTransparentNavbar)
        }
    </script>
@endpush
