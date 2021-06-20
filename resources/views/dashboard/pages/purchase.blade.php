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
                                <td>Total Biaya</td>
                                <td>Ekspedisi</td>
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
                                        @php
                                            $total_price = 0;
                                        @endphp
                                        @foreach ($purchase->purchase_details as $purchase_detail)
                                            {{ $purchase_detail->product->name.', @'.$purchase_detail->quantity.' ('.$purchase_detail->total_price_rupiah.')'}}

                                            @if ($purchase_detail->product->status == 'preorder')
                                                <span class="badge badge-warning">Preorder</span><br>
                                            @endif
                                            @php
                                                $total_price += $purchase_detail->total_price;
                                            @endphp
                                            <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        {{ $purchase->formatted_purchase_date}}
                                    </td>
                                    <td>
                                        {{
                                            $purchase->total_cost_rupiah
                                        }}
                                    </td>
                                    <td>
                                        @if ($purchase->self_take == 1)
                                            Ambil Sendiri
                                        @else
                                            @if ($purchase->courier == NULL)
                                                Kurir belum dipilih
                                            @else
                                                {{ $purchase->courier}} @ {{ $purchase->courier_cost_rupiah}}
                                            @endif
                                        @endif
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-12 col-md-12 px-1 mb-1">
                                                <form
                                                    action="{{ route('purchase.confirm', $purchase->id) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="button" class="btn btn-sm btn-block btn-success btn-confirm-purchase">Confirm</button>
                                                </form>
                                            </div>
                                            <div class="col-12 col-md-12 px-1 mb-1">
                                                <a href="{{ route('purchase.cetak-resi', $purchase->id) }}" target="_blank" class="btn btn-block btn-default btn-sm" rel="noopener noreferrer">
                                                    Cetak Resi
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


    <!-- Modal -->
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
                            <h1>asdas</h1>
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
    });


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
