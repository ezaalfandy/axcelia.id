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
            <div class="col-md-3">
                <img src="{{ asset('dashboard/img/logo-axcelia.png')}}" alt="" class="img-fluid">
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <p class="font-weight-bold mb-1">Nota Untuk :</p>
                <p>
                    {{ $user->name}} ({{ $user->phone_number}})
                </p>
            </div>
            <div class="col-md-12">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-sm">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Produk</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Diskon</th>
                                <th class="text-right">Total Harga</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($purchase_details as $purchase_detail)
                                <tr>
                                    <td>
                                        {{ $purchase_detail->key + 1}}
                                    </td>
                                    <td>
                                        {{ $purchase_detail->product->name }}
                                    </td>
                                    <td>
                                        {{ $purchase_detail->quantity }}
                                    </td>
                                    <td>
                                        {{ $purchase_detail->product->price_rupiah }}
                                    </td>
                                    <td>
                                        {{ $purchase_detail->discount }}%
                                    </td>
                                    <td class="text-right">
                                        {{ $purchase_detail->total_price_rupiah }}
                                    </td>
                                </tr>
                            @endforeach
                            <tr class="font-weight-bold text-right">
                                <td colspan="5">
                                    Grand Total
                                </td>
                                <td>
                                    {{ $purchase->total_cost_rupiah}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
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
