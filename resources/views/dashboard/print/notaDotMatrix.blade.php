<!DOCTYPE html>
<html lang="en">

<head>
    {{-- @include('dashboard.layouts.head') --}}
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
            font-size: 12px;
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
            font-size: 12px;
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

    <img src="{{ asset('dashboard/img/logo-axcelia.png')}}" alt="" class="img-fluid"><br>
    <p style="text-align: center; margin: 2mm 0mm;">
        Perum. Mutiara Garden blok C no 1. <br>Kel. Lengkong. Kec. Mojoanyar. <br>Mojokerto
    </p>

    <div class="data-order">
        <div>
            <div class="kolom-kiri">
                Nama
            </div>
            <div class="kolom-kanan">
                : {{ $user->name }}
            </div>
        </div>
        <div>
            <div class="kolom-kiri">
                No. Order
            </div>
            <div class="kolom-kanan">
                : {{ $purchase->payment_receipt }}
            </div>
        </div>
        <div>
            <div class="kolom-kiri">
                Tanggal
            </div>
            <div class="kolom-kanan">
                : {{ $purchase->formatted_purchase_date }}
            </div>
        </div>
        <div>
            <div class="kolom-kiri">
                Berat
            </div>
            <div class="kolom-kanan">
                : {{ $purchase->formatted_total_weight}}
            </div>
        </div>
        <div>
            <div class="kolom-kiri">
                Total Item
            </div>
            <div class="kolom-kanan">
                : {{ $purchase->total_items}} pcs
            </div>
        </div>
    </div>
    <br>
    <p style="margin:0px;">=================================</p>
    <div class="daftar">
        <div>
            <div class="produk">
                Produk
            </div>
            <div class="jumlah">
                jmlh
            </div>
            <div class="harga">
                harga
            </div>
            <div class="total">
                Total
            </div>
        </div>
    </div>
    <p style="margin:0px;">=================================</p>
    <div class="daftar">
            @foreach ($purchase_details as $purchase_detail)
                <div>
                    <div class="produk">
                        {{ $purchase_detail->product->name }}
                    </div>
                    <div class="jumlah">
                        {{ $purchase_detail->quantity }}
                    </div>
                    <div class="harga">
                        {{ $purchase_detail->product->price_rupiah }}
                    </div>
                    <div class="total">
                        {{ $purchase_detail->total_price_rupiah_no_discount }}
                    </div>
                </div>
            @endforeach
    </div>
    <p>=================================</p>
    <div class="ringkasan">
        <div>
            <div class="kolom-kiri">
                Total Belanja
            </div>
            <div class="separator">
                :
            </div>
            <div class="kolom-kanan">
                {{ $purchase->total_cost_rupiah_no_discount}}
            </div>
        </div>
        <div>
            <div class="kolom-kiri">
                Ongkir
            </div>
            <div class="separator">
                :
            </div>
            <div class="kolom-kanan">
                {{ $purchase->courier_cost_rupiah}}
            </div>
        </div>
        <div>
            <div class="kolom-kiri">
                Diskon
            </div>
            <div class="separator">
                :
            </div>
            <div class="kolom-kanan">
                {{ $purchase->total_discount_rupiah}}
            </div>
        </div>
        <div>
            <div class="kolom-kiri">
                Total Bayar
            </div>
            <div class="separator">
                :
            </div>
            <div class="kolom-kanan">
                {{ $purchase->total_cost_rupiah}}
            </div>
        </div>
    </div>

    <p>=================================</p>
    <div style="width:100%; text-align: center;font-size: 12px; margin: 0mm 0mm 3cm 0mm;">
        Dicetak Oleh : {{ Auth::user()->name }}
    </div>
    <p style="margin:0px;">=================================</p>

    <script>
            window.print();
    </script>
</body>

</html>
