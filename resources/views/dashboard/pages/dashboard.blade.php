@extends('dashboard.layouts.app')
@section('main')
<div class="row">
    <div class="col-md-12">
        <div class="card card-stats">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-primary">
                                    <i class="now-ui-icons business_money-coins"></i>
                                </div>
                                <h3 class="info-title">{{ $purchase_waiting_confirmation}}</h3>
                                <h6 class="stats-title">Menunggu Konfirmasi</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-success">
                                    <i class="now-ui-icons business_money-coins"></i>
                                </div>
                                <h3 class="info-title">{{ $purchase_waiting_payment}}</h3>
                                <h6 class="stats-title">Menunggu Pembayaran</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-info">
                                    <i class="now-ui-icons users_single-02"></i>
                                </div>
                                <h3 class="info-title">{{ $total_user_approved }}</h3>
                                <h6 class="stats-title">User Approved</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-warning">
                                    <i class="now-ui-icons users_single-02"></i>
                                </div>
                                <h3 class="info-title">{{ $total_user_waiting }}</h3>
                                <h6 class="stats-title">User Waiting</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-success">
                                    <i class="now-ui-icons shopping_box"></i>
                                </div>
                                <h3 class="info-title">{{ $active_product }}</h3>
                                <h6 class="stats-title">Produk Aktif</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-danger">
                                    <i class="now-ui-icons shopping_box"></i>
                                </div>
                                <h3 class="info-title">{{ $nonactive_product }}</h3>
                                <h6 class="stats-title">Produk Non Aktif</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-info">
                                    <i class="now-ui-icons shopping_box"></i>
                                </div>
                                <h3 class="info-title">{{ $preorder_product }}</h3>
                                <h6 class="stats-title">Produk Pre Order</h6>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="statistics">
                            <div class="info">
                                <div class="icon icon-primary">
                                    <i class="now-ui-icons business_money-coins"></i>
                                </div>
                                <h3 class="info-title">{{ 'Rp '.number_format($income_this_month, 0, ".", ".") }}</h3>
                                <h6 class="stats-title">Pendapatan Bulan Ini</h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">
                    Produk Terlaris Bulan Ini
                </h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="tableTopSales">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Name</td>
                            <td>Quantity</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($top_sales_this_month as $item)
                        <tr>
                            <td></td>
                            <td>{{ $item->productVarian->full_name }}</td>
                            <td>{{ $item->total }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        var tablePurchases = $('#tablePurchases').DataTable({
            "pagingType": "simple",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "10%", "targets": -1 },
                {"width": "3%", "targets": 0},
                {"width": "10%", "targets": 1},
                {"width": "25%", "targets": 2},
            ],
            responsive: true,
            autoWidth: false
        });

        tablePurchases.on('order.dt search.dt', function () {
            tablePurchases.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();


        var tableTopSales = $('#tableTopSales').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "10%", "targets": -1 },
                {"width": "3%", "targets": 0},
                {"width": "10%", "targets": 1},
                {"width": "25%", "targets": 2},
            ],
            responsive: true,
            autoWidth: false
        });

        tableTopSales.on('order.dt search.dt', function () {
            tableTopSales.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });
</script>
@endpush
