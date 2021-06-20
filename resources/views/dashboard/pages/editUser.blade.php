@extends('dashboard.layouts.app')
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card ">
                <div class="card-header ">
                    <h4 class="card-title">{{ ucfirst($user->name) . ' - ' . $user->phone_number }}</h4>
                </div>
                <div class="card-body ">
                    <ul class="nav nav-pills nav-pills-primary" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#keranjang" role="tablist">
                                Keranjang
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#pembelian" role="tablist">
                                Daftar Pembelian
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#profil" role="tablist">
                                Edit Profil
                            </a>
                        </li>
                    </ul>
                    <div class="tab-content tab-space">
                        <div class="tab-pane active" id="keranjang">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped" id="tableShoppingCarts">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Product</td>
                                                <td>tanggal</td>
                                                <td>Quantity</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($shopping_carts as $shopping_cart)
                                                <tr>
                                                    <td></td>
                                                    <td>{{ $shopping_cart->product->name }}</td>
                                                    <td>{{ $shopping_cart->formatted_created_date }}</td>
                                                    <td>{{ $shopping_cart->quantity }}</td>
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
                        <div class="tab-pane" id="pembelian">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped" id="tablePurchases">
                                        <thead>
                                            <tr>
                                                <td>No</td>
                                                <td>Items</td>
                                                <td>Tanggal Order</td>
                                                <td>Total Biaya</td>
                                                <td>Status</td>
                                                <td></td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($purchases as $purchase)
                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        @php
                                                            $total_price = 0;
                                                        @endphp
                                                        @foreach ($purchase->purchase_details as $purchase_detail)
                                                            {{ $purchase_detail->product->name . ', Qt = ' . $purchase_detail->quantity . ' (Rp ' . $purchase_detail->total_price . ')' }}

                                                            @if ($purchase_detail->product->status == 'preorder')
                                                                <span class="badge badge-warning">Preorder</span><br>
                                                            @endif
                                                            @php
                                                                $total_price += $purchase_detail->total_price;
                                                            @endphp
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        {{ $purchase->formatted_purchase_date }}
                                                    </td>
                                                    <td>
                                                        @php
                                                            echo 'Rp ' . number_format($total_price, 0, '.', '.');
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @if ($purchase->status == 'complete')
                                                            <span class="badge badge-success">Selesai</span>
                                                        @else
                                                            <span class="badge badge-warning">Menunggu</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        <form class="d-inline-block"
                                                            action="{{ route('purchase.destroy', $purchase->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="button"
                                                                class="btn btn-sm btn-danger btn-delete-purchase">Delete</button>
                                                        </form>
                                                        <form class="d-inline-block"
                                                            action="{{ route('purchase.confirm', $purchase->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <button type="button"
                                                                class="btn btn-sm btn-success btn-confirm-purchase">Confirm</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane" id="profil">
                            <form method="POST" novalidate="novalidate" id="formEditUsers"
                                action="{{ route('user.update', $user->id) }} ">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_users_name">Name</label>
                                            <input type="text" name="name" value="{{ $user->name }}" id="edit_users_name"
                                                class="form-control" required="true" />
                                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_users_email">Email</label>
                                            <input type="text" name="email" value="{{ $user->email }}"
                                                id="edit_users_email" class="form-control" required="true" />
                                            @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="edit_users_phone_number">Phone Number</label>
                                            <input type="text" name="phone_number" value="{{ $user->phone_number }}"
                                                id="edit_users_phone_number" class="form-control" required="true" />
                                            @error('phone_number')<small
                                                class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <p>Status</p>
                                            <div class="form-check form-check-radio">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" required="true"
                                                        name="status" value="approved" @if ($user->status == 'approved') checked @endif>
                                                    <span class="form-check-sign"></span>
                                                    Approved
                                                </label>
                                            </div>
                                            <div class="form-check form-check-radio">
                                                <label class="form-check-label">
                                                    <input class="form-check-input" type="radio" @if ($user->status == 'waiting') checked @endif required="true" name="status" value="waiting">
                                                    <span class="form-check-sign"></span>
                                                    Waiting
                                                </label>
                                            </div>
                                            @error('status')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn btn-primary btn-block" type="submit">Edit</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            var tablePurchases = $('#tablePurchases').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "columnDefs": [{
                        "width": "15%",
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

            tablePurchases.on('order.dt search.dt', function() {
                tablePurchases.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });

        $('#formEditUsers').on('change', '[name="province"]', function(e) {
            //GET JSON KABUPATEN_KOTA
            $.getJSON("{{ route('user.get-city') }}" + "/" + e.target.value,
                function(data, textStatus, jqXHR) {
                    $('#formEditUsers [name="city"]').html('');
                    $.each(data, function(i, v) {
                        $('#formEditUsers [name="city"]').append('<option value="' + v + '">' + v +
                            '</option>');
                    });
                    $('#formEditUsers [name="city"]').selectpicker('refresh');
                }
            );
        });

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
