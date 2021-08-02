@extends('dashboard.layouts.app')
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Order
                        @if (Request::segment(1) == 'purchase-complete')
                            Selesai
                        @endif
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tablePurchases">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Pembeli</td>
                                <td class="not-mobile">Items</td>
                                <td class="not-mobile">Tanggal Order</td>
                                <td>Ekspedisi</td>
                                <td>Total Yang Harus Dibayar</td>
                                <td class="not-mobile"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                    <td></td>
                                    <td>
                                        <a href="{{ route('user.edit', $purchase->user->id) }}">
                                            {{ $purchase->user->name }}</a><br>
                                        {{ $purchase->user->phone_number}}
                                    </td>
                                    <td>
                                        @foreach ($purchase->purchase_details as $purchase_detail)
                                            {{ $purchase_detail->productVarian->full_name.', '.$purchase_detail->quantity.' x '.$purchase_detail->price_rupiah.''}}
                                            <br>
                                            Diskon :
                                            {{
                                                $purchase_detail->total_discount_rupiah ? ' - '.$purchase_detail->total_discount_rupiah : ''
                                            }}

                                            =
                                            {{ $purchase_detail->total_price_rupiah}}
                                            @if ($purchase_detail->productVarian->status == 'preorder')
                                                <br><span class="badge badge-warning">Preorder</span>
                                            @endif

                                            @if ($purchase_detail->description != NULL && $purchase_detail->description != ' ')
                                                <br>Note : {{ $purchase_detail->description }}
                                            @endif
                                            <br>
                                            <br>
                                        @endforeach
                                        <b>Total Belanja : {{ $purchase->total_cost_rupiah_no_courier}}</b>
                                    </td>
                                    <td>
                                        <u>{{ $purchase->formatted_purchase_date}}</u><br>
                                        No Nota : {{ $purchase->payment_receipt}}
                                    </td>
                                    <td>
                                        @if ($purchase->self_take == 1)
                                            Ambil Sendiri
                                        @else
                                            @if ($purchase->courier == NULL)
                                                Kurir belum dipilih
                                            @else
                                                {{ $purchase->courier}} <br>
                                                {{ $purchase->courier_cost_rupiah}}<br>
                                                Resi : {{ $purchase->receipt_number }}<br>
                                                Dikirim ke :
                                                {{ $purchase->subdistrict.' - '.$purchase->city}}<br>
                                                {{ $purchase->province}}<br>
                                                @if ($purchase->dropship == 1)
                                                    <span class="badge badge-primary">Dropship</span><br>
                                                @endif
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <b>
                                            {{
                                                $purchase->total_cost_rupiah
                                            }}
                                        </b>
                                        <br>
                                        @if ($purchase->status !== 'complete')
                                            @if ($purchase->status == 'waiting_payment')
                                                <span class="badge badge-warning">Menunggu Pembayaran</span>
                                            @else
                                                <span class="badge badge-info">Menunggu Konfirmasi</span>
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="row">
                                            @if ($purchase->status !== 'complete')
                                                <div class="col-12 col-md-12 px-1 mb-1">
                                                    <form
                                                        action="{{ route('purchase.confirm', $purchase->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn btn-sm btn-block btn-success btn-confirm-purchase">Confirm</button>
                                                    </form>
                                                </div>
                                                <div class="col-12 px-1 mb-1">
                                                    <button class="btn btn-sm btn-info btn-block btn-diskon"
                                                        data-url="{{ route('purchase.show', $purchase->id) }}"
                                                        data-post="{{ route('purchase.update-discount', $purchase->id) }}"
                                                    >
                                                        Diskon
                                                    </button>
                                                </div>
                                            @else
                                                @if ($purchase->self_take == 0)
                                                    <div class="col-12 px-1 mb-1">
                                                        <button class="btn btn-sm btn-info btn-block btn-resi"
                                                            data-post="{{ route('purchase.update-resi', $purchase->id) }}"
                                                        >
                                                            Input Resi
                                                        </button>
                                                    </div>
                                                @endif
                                            @endif
                                            <div class="col-12 col-md-12 px-1 mb-1">
                                                <a href="{{ route('purchase.cetak-resi', $purchase->id) }}" target="_blank" class="btn btn-block btn-default btn-sm" rel="noopener noreferrer">
                                                    Cetak Resi
                                                </a>
                                            </div>
                                            <div class="col-12 col-md-12 px-1 mb-1">
                                                <a href="{{ route('purchase.cetak-nota', $purchase->id) }}" target="_blank" class="btn btn-block btn-default btn-sm" rel="noopener noreferrer">
                                                    Cetak Nota
                                                </a>
                                            </div>
                                            <div class="col-12 col-md-12 px-1 mb-1">
                                                <form
                                                    action="{{ route('purchase.destroy', $purchase->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="button" class="btn btn-sm btn-block btn-danger btn-delete-purchase">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalDiskon" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form
                    action=""
                    method="post"
                >
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="confirm" value="0">
                    <div class="modal-header">
                        <h5 class="modal-title">Atur Diskon</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary btn-save-confirm-discount">Save & Confirm</button>
                        <button type="submit" class="btn btn-primary btn-link">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalPickCourier" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form
                    action=""
                    method="POST"
                >
                    <div class="modal-header">
                        <h5 class="modal-title">Pilih Kurir</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <div class="col-12 radio-container">

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalNomorResi" tabindex="-1" role="dialog" aria-labelledby="modelTitleId" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <form action="" method="post">
                @method('PUT')
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Input Resi</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                          <label for="receipt_number">Nomor Resi</label>
                          <input type="text"
                            class="form-control" name="receipt_number" id="receipt_number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('js')
<script>
    $(document).ready(function () {
        var tablePurchases = $('#tablePurchases').DataTable({
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "10%", "targets": -1 },
                {"width": "3%", "targets": 0},
                {"width": "7%", "targets": 1},
                {"width": "35%", "targets": 2},
            ],
            responsive: true,
            autoWidth: false
        });

        tablePurchases.on('order.dt search.dt', function () {
            tablePurchases.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        } ).draw();
    });

    $('.btn-save-confirm-discount').on('click', function(e){
        $('#modalDiskon [name="confirm"]').val(1);
        $('#modalDiskon form').submit();
        $('#modalDiskon [name="confirm"]').val(0);
    })

    $('.btn-delete-purchase').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: 'Apakah Anda Yakin ?',
            text: "Data purchase akan dihapus dan tidak dapat dikembalikan !",
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

    $('.btn-resi').on('click', function (e) {
        $('#modalNomorResi form').attr('action', $(this).data('post'));
        $('#modalNomorResi').modal('show');
    });

    $('.btn-diskon').on('click', function (e) {
        $('#modalDiskon form').attr('action', $(this).data('post'));
        $.getJSON($(this).data('url'), function (data, textStatus, jqXHR) {
                $('#modalDiskon .modal-body').empty();
                $.each(data, function (i, v) {
                    $('#modalDiskon .modal-body').append(
                        `
                            <div class="row">
                                <div class="col-md-12">
                                    <label>`+v.product_varian.full_name+` @`+v.quantity+`</label>
                                    <input type="number" name="discount[]" value="`+v.discount+`" class="form-control">
                                </div>
                            </div>
                        `
                    );
                });
                $('#modalDiskon').modal('show');
            }
        );
    });


    $('.btn-pick-courier').on('click', function (e) {
        $link = $(this).data('link');
        $.getJSON($link,
            function (data, textStatus, jqXHR) {
                if(data.rajaongkir.status.code == 200)
                {
                    $('#modalPickCourier .modal-body .radio-container').html('');
                    console.log();
                    $.each(data.rajaongkir.results, function (i_courier, v_courier) {
                            console.log(v_courier);
                        $.each(v_courier.costs, function (i_cost, v_cost) {
                            $('#modalPickCourier .modal-body .radio-container').append(
                                `
                                    <div class="form-check form-check-radio pl-0">
                                        <label class="form-check-label">
                                            <input class="form-check-input" type="radio" name="brand" id="insert_products_brand" value="axcelia" required="true">
                                            <span class="form-check-sign"></span>
                                            `+v_courier.code+` `+v_cost.service+` Rp `+(v_cost.cost[0].value/1000).toFixed(3)+ ` (etd : `
                                            +
                                                v_cost.cost[0].etd
                                            +` Hari )
                                        </label>
                                    </div>
                                `
                            );
                        });
                    });
                    $('#modalPickCourier').modal('show');
                }else{
                    alert('system error');
                }
            }
        );
    });


    $('.btn-confirm-purchase').on('click', function (e) {
        e.preventDefault();
        var form = $(this).parents('form');
        swal({
            title: 'Apakah Anda Yakin ?',
            text: "Penjualan dilakukan !",
            type: 'info',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-info',
            cancelButtonClass: 'btn btn-default btn-link',
            confirmButtonText: 'Ya, Jual',
            buttonsStyling: false
        }).then(function(result) {
            if(result.value === true){
                $(form).submit();
            }
        })
    });

    app.setFormValidation('#formInsertPurchase');

    app.setFormValidation('#formEditPurchase');
    function openModalEditPurchase($getUrl, $updateUrl){
        $.getJSON($getUrl,
            function (data, textStatus, jqXHR) {
                $('#formEditPurchase .form-group').addClass('is-filled');
                        $('#formEditPurchase [name="id"]').val(data.id);
                        $('#formEditPurchase [name="status"]').selectpicker('val', data.status);
                        $('#formEditPurchase').attr('action', $updateUrl);
                $('#modalEditPurchase').modal('show');
            }
        );
    }
</script>

@endpush
