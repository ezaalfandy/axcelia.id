@extends('dashboard.layouts.app')
@section('main')
<div class="row">
    <div class="col-md-5">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Daftar Varian</h4>
            </div>
            <div class="card-body">
                <button type="button" class="btn btn-outline-primary mb-4 mt-0" data-toggle="modal"
                    data-target="#modalInsertProductVarian">
                    Tambah Product Varian
                </button>

                <table class="table table-striped" id="tableProductVarians">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Name</td>
                            <td>Stock</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($product_varians as $product_varian)
                        <tr>
                            <td></td>
                            <td>{{ $product_varian->name }}</td>
                            <td>{{ $product_varian->stock }}</td>
                            <td>
                                <form class="d-inline-block"
                                    action="{{ route('product-varian.destroy', $product_varian->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button"
                                        class="btn btn-danger btn-sm btn-delete-product_varian">Delete</button>
                                </form>
                                <button class="btn btn-info btn-sm" onclick="openModalEditProductVarian(
                                        '{{ route('product-varian.show', $product_varian->id) }}',
                                        '{{ route('product-varian.update', $product_varian->id) }}'
                                    )">
                                    Edit / Restock
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="col-md-7">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Riwayat Stok</h4>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="tableInboundStocks">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Varian</td>
                            <td>Tanggal</td>
                            <td>Stok Masuk</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($inbound_stocks as $inbound_stock)
                            <tr>
                                <td></td>
                                <td>{{ $inbound_stock->productVarian->full_name }}</td>
                                <td>{{ $inbound_stock->created_at }}</td>
                                <td>{{ $inbound_stock->stock_change }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Penjualan</h4>
            </div>
            <div class="card-body">

                <table class="table table-striped" id="tablePurchaseDetails">
                    <thead>
                        <tr>
                            <td>No</td>
                            <td>Pembeli</td>
                            <td>Produk</td>
                            <td>Quantity</td>
                            <td>Tanggal</td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase_details as $purchase_detail)
                            <tr>
                                <td></td>
                                <td>{{ $purchase_detail->purchase->user->name }}</td>
                                <td>{{ $purchase_detail->productVarian->full_name }}</td>
                                <td>{{ $purchase_detail->quantity }}</td>
                                <td>{{ $purchase_detail->purchase->created_at }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalEditProductVarian" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" novalidate="novalidate" id="formEditProductVarian" action="">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title">Edit product varian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" value="{{ $product->id}}" />

                    <div class="form-group">
                        <label for="edit_product_varians_name">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="edit_product_varians_name"
                            class="form-control" required="true" />
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label for="edit_product_varians_stock">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" id="edit_product_varians_stock"
                            class="form-control" required="true" min="0" />
                        @error('stock')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Edit product varian</button>
                    <button class="btn btn-outline-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="modalInsertProductVarian" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" novalidate="novalidate" id="formInsertProductVarian"
                action="{{ route('product-varian.store') }} ">
                @csrf
                @method('POST')
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Product Varian</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="product_id" value="{{ $product->id}}" />

                    <div class="form-group">
                        <label for="insert_product_varians_name">Name</label>
                        <input type="text" name="name" value="{{ old('name') }}" id="insert_product_varians_name"
                            class="form-control" required="true" />
                        @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                    <div class="form-group">
                        <label for="insert_product_varians_stock">Stock</label>
                        <input type="number" name="stock" value="{{ old('stock') }}" id="insert_product_varians_stock"
                            class="form-control" required="true" min="0" />
                        @error('stock')<small class="text-danger">{{ $message }}</small>@enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary" type="submit">Tambah product varian</button>
                    <button class="btn btn-outline-default" data-dismiss="modal">Tutup</button>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection
@push('js')

<script>
    $(document).ready(function () {
        var tableProductVarians = $('#tableProductVarians').DataTable({
            "pagingType": "numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "55%", "targets": -1 },
                {"width": "10%", "targets": 0}
            ],
            responsive: true,
            autoWidth: false
        });

        tableProductVarians.on('order.dt search.dt', function () {
            tableProductVarians.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });


    $(document).ready(function () {
        var tableInboundStocks = $('#tableInboundStocks').DataTable({
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "20%", "targets": -1 },
                {"width": "10%", "targets": 0}
            ],
            responsive: true,
            autoWidth: false
        });

        tableInboundStocks.on('order.dt search.dt', function () {
            tableInboundStocks.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });

    $(document).ready(function () {
        var tablePurchaseDetails = $('#tablePurchaseDetails').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "20%", "targets": -2 },
                {"width": "5%", "targets": 0}
            ],
            responsive: true,
            autoWidth: false
        });

        tablePurchaseDetails.on('order.dt search.dt', function () {
            tablePurchaseDetails.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });


    $('.btn-delete-product_varian').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: 'Apakah Anda Yakin ?',
            text: "Data product_varian akan dihapus dan tidak dapat dikembalikan !",
            type: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-danger',
            cancelButtonClass: 'btn btn-default btn-link',
            confirmButtonText: 'Ya, Hapus',
            buttonsStyling: false
        }).then(function(result) {
            if(result.value === true){
                $(form).submit();
            }
        })
    });


    app.setFormValidation('#formInsertProductVarian');

    app.setFormValidation('#formEditProductVarian');
    function openModalEditProductVarian($getUrl, $updateUrl){
        $.getJSON($getUrl,
            function (data, textStatus, jqXHR) {
                $('#formEditProductVarian .form-group').addClass('is-filled');
                $('#formEditProductVarian [name="id"]').val(data.id);
                $('#formEditProductVarian [name="name"]').val(data.name);
                $('#formEditProductVarian [name="stock"]').val(data.stock);
                $('#formEditProductVarian').attr('action', $updateUrl);
                $('#modalEditProductVarian').modal('show');
            }
        );
    }
</script>

@endpush
