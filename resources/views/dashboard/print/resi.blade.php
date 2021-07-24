<!DOCTYPE html>
<html lang="en">

<head>
    @include('dashboard.layouts.head')
    <style>
        @page{
            size:auto;
            margin:0mm;
        }
        body{
            width: 210mm;
            height: 148mm;
            margin: 0mm;
        }
        .content{
            width: 210mm;
            min-height: 148mm;
            overflow: auto;
        }

        html{
            padding: 0mm;
            width: 210mm;
            height: 148mm;
            margin: 0mm;
        }
        img{
            width: 4cm;
            margin-bottom: 1cm;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3">
                                <img src="{{ asset('dashboard/img/logo-axcelia.png')}}" alt="" class="img-fluid">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <h2 class="font-weight-bold">Dari :</h2>
                                <h3>Perum. Mutiara Garden blok C no 1. <br>Kel. Lengkong. Kec. Mojoanyar. <br>Mojokerto</h3>
                            </div>
                            <div class="col-md-12">
                                <h2 class="font-weight-bold">Kepada :</h2>
                                <h3>
                                    {{ $user->name}}<br>
                                    {{ $purchase->address}}<br>
                                    {{ $purchase->subdistrict.' - '.$purchase->city}}<br>
                                    {{ $purchase->province}}<br>
                                    {{ $user->phone_number}}<br>
                                </h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('dashboard')}}/js/app.js"></script>
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>
</body>

</html>
