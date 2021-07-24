@extends('dashboard.layouts.app')
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar {{ Str::ucfirst(Request::segment(1)) }}</h4>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tableShoppingCarts">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>User</td>
                                <td>Tanggal</td>
                                <td>Product</td>
                                <td>Quantity</td>
                                <td>Description</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($shopping_carts as $shopping_cart)
                                <tr>
                                    <td></td>
                                    <td>
                                        {{ $shopping_cart->user->name }}<br>
                                        {{ $shopping_cart->user->phone_number}}
                                    </td>
                                    <td>{{ $shopping_cart->formatted_created_date }}</td>
                                    <td>
                                        {{ $shopping_cart->product->name }}
                                        @if ($shopping_cart->product->status == 'preorder')
                                            <br><span class="badge badge-warning">Preorder</span>
                                        @endif
                                    </td>
                                    <td>{{ $shopping_cart->quantity }}</td>
                                    <td>{{ $shopping_cart->description }}</td>
                                    <td>
                                        <form class="d-inline-block"
                                            action="{{ route('shopping-cart.destroy', $shopping_cart->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-sm btn-danger  btn-delete-shopping_cart">Delete</button>
                                        </form>
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
        $(document).ready(function() {
            var tableShoppingCarts = $('#tableShoppingCarts').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "columnDefs": [{
                        "width": "10%",
                        "targets": -1
                    },
                    {
                        "width": "5%",
                        "targets": 0
                    }
                ],
                responsive: true,
                autoWidth: false
            });

            tableShoppingCarts.on('order.dt search.dt', function() {
                tableShoppingCarts.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });


        $('.btn-delete-shopping_cart').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: 'Apakah Anda Yakin ?',
                text: "Data shopping_cart akan dihapus dan tidak dapat dikembalikan !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-danger',
                cancelButtonClass: 'btn btn-default btn-link',
                confirmButtonText: 'Ya, Hapus',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value === true) {
                    $(form).submit();
                }
            })
        });

    </script>
@endpush
