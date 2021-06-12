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
                                <td>Items</td>
                                <td>Total Biaya</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($purchases as $purchase)
                                <tr>
                                <td></td>
                                    <td>
                                        {{ $purchase->user->name }}<br>
                                        {{ $purchase->user->phone_number}}
                                    </td>
                                    <td>
                                        @php
                                            $total_price = 0;
                                        @endphp
                                        @foreach ($purchase->purchase_details as $purchase_detail)
                                            {{ $purchase_detail->product->name.', Qt = '.$purchase_detail->quantity.' (Rp '.$purchase_detail->total_price.')'}}

                                            @if ($purchase_detail->product->status == 'preorder')
                                                <span class="badge badge-warning">Preorder</span><br>
                                            @endif
                                            @php
                                                $total_price += $purchase_detail->total_price;
                                            @endphp
                                        @endforeach
                                    </td>
                                    <td>
                                        @php
                                            echo 'Rp '.number_format($total_price, 0, ".", ".");
                                        @endphp
                                    </td>
                                    <td>
                                        <form class="d-inline-block"
                                            action="{{ route('purchase.destroy', $purchase->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" class="btn btn-link btn-danger  btn-delete-purchase">Delete</button>
                                        </form>
                                        <button class="btn btn-info btn-link btn-sm"
                                            onclick="openModalEditPurchase(
                                                '{{ route('purchase.show', $purchase->id) }}',
                                                '{{ route('purchase.update', $purchase->id) }}'
                                            )"
                                        >
                                            Edit
                                        </button>
                                    </td>
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
            "pagingType": "full_numbers",
            "lengthMenu": [
                [10, 25, 50, -1],
                [10, 25, 50, "All"]
            ],
            "columnDefs": [
                { "width": "10%", "targets": -1 },
                {"width": "5%", "targets": 0}
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
