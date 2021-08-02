<!DOCTYPE html>
<html lang="en">

<head>
    {{-- @include('dashboard.layouts.head')/ --}}

    <style>
        *{
            box-sizing: border-box;
        }
        @page{
            size:auto;
            margin:0mm;
        }
        body{
            width: 80mm;
            margin: 0mm;
        }
        html{
            padding: 0mm;
            width: 80mm;
            margin: 0mm;
        }
        img{
            width: 30mm;
            margin: 0mm 25mm 0mm 25mm;
        }
        .daftar{
            width: 100%;
            padding: 0%;
            font-size: 15px;
        }
        .daftar > div{
            width: 100%;
            display: block;
        }
        .produk{
            float: left;
            width: 40%;
        }
        .jumlah{
            width: 5%;
            float: left;
            text-align: right;
        }
        .harga{
            width: 25%;
            float: left;
            text-align: right;
        }
        .total{
            width: 30%;
            float: left;
            text-align: right;
        }

        .data-order, .ringkasan{
            width: 100%;
            padding: 0%;
            font-size: 15px;
            margin: 4mm 0mm;
        }
        .daftar > div{
            width: 100%;
            display: block;
        }

        .data-order .kolom-kanan, .data-order .kolom-kiri{
            width: 50%;
            float: left;
        }

        .ringkasan{
            margin: 0px;
        }
        .ringkasan .kolom-kanan, .ringkasan .kolom-kiri{
            width: 45%;
            float: left;
        }

        .ringkasan .separator{
            width: 10%;
            float: left;
        }

        .ringkasan .kolom-kanan{
            text-align: right;
        }

        @media print {
            body{
                /* width: 80mm; */
                margin: 0mm;
            }
            html{
                padding: 0mm;
                /* width: 80mm; */
                margin: 0mm;
            }
        }
    </style>
</head>

<body>
    <div class="content">

        @if ($purchase->dropship == 0)
            <img src="{{ asset('dashboard/img/logo-axcelia.png')}}" alt="" class="img-fluid">
        @endif
        <p class="font-weight-bold"><b>Dari :</b></p>
        @if ($purchase->dropship == 1)
            {{ $purchase->sender_name}}
        @else
            Axcelia.id
        @endif
        <p>
            Perum. Mutiara Garden blok C no 1. <br>Kel. Lengkong. Kec. Mojoanyar. <br>Mojokerto
            <br>
            @if ($purchase->dropship == 1)
                {{ $purchase->sender_phone_number}}
            @else
                0857 3173 3546
            @endif
        </p>

        <p class="font-weight-bold"><b>Kepada :</b></p>
        <p>
            {{ $user->name}}<br>
            {{ $purchase->address}}<br>
            {{ $purchase->subdistrict.' - '.$purchase->city}}<br>
            {{ $purchase->province}}<br>
            {{ $user->phone_number}}<br>
        </p>
    </div>
    <script src="{{ asset('dashboard')}}/js/app.js"></script>
    <script>
        $(document).ready(function () {
            window.print();
        });
    </script>
</body>

</html>
