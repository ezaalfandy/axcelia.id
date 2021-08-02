@extends('dashboard.layouts.app')
@section('main')
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title">Daftar Produk {{ Str::ucfirst(Request::segment(1))}}</h4>
                </div>
                <div class="card-body">

                    <button type="button" class="btn btn-outline-primary mb-4 mt-0" data-toggle="modal"
                        data-target="#modalInsertProduct">
                        Tambah Produk
                    </button>

                    <table class="table table-striped" id="tableProducts">
                        <thead>
                            <tr>
                                <td>No</td>
                                <td>Name</td>
                                <td>Price</td>
                                <td>Total Stock</td>
                                <td>varians</td>
                                <td class="not-mobile"></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $product)
                                <tr>
                                    <td></td>
                                    <td>{{ $product->name }}</td>
                                    <td>{{ $product->price_rupiah }}</td>
                                    <td>{{ $product->stock }}</td>
                                    <td>
                                        @foreach ($product->productVarian as $item)
                                            {{
                                                $item->name.' = '.$item->stock.' pcs'
                                            }} <br>
                                        @endforeach
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit', $product->id)}}" class="btn btn-success btn-sm">
                                            Detail
                                        </a>
                                        <button class="btn btn-info btn-sm" onclick="openModalEditProduct(
                                                                '{{ route('product.show', $product->id) }}',
                                                                '{{ route('product.update', $product->id) }}'
                                                            )">
                                            Edit
                                        </button>
                                        <form class="d-inline-block" action="{{ route('product.destroy', $product->id) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-danger btn-sm btn-delete-product">Delete</button>
                                        </form>
                                        <div class="d-inline-block dropleft">
                                            <button class="btn btn-sm btn-secondary dropdown-toggle" type="button" id="buttonMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class="now-ui-icons design_bullet-list-67"></i>
                                            </button>
                                            <div class="dropdown-menu" aria-labelledby="buttonMenu">
                                                @if ($product->status !== 'available')
                                                    <form  action="{{ route('product.change-status', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="text" class="d-none" value="available" name="status">
                                                        <button type="button"
                                                            class="dropdown-item btn-status-product">Aktifkan Produk</button>
                                                    </form>
                                                @endif
                                                @if ($product->status !== 'preorder')
                                                    <form action="{{ route('product.change-status', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="text" class="d-none" value="preorder" name="status">
                                                        <button type="button"
                                                            class="dropdown-item btn-status-product">Ubah ke pre order</button>
                                                    </form>
                                                @endif
                                                @if ($product->status !== 'unavailable')
                                                    <form  action="{{ route('product.change-status', $product->id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('POST')
                                                        <input type="text" class="d-none" value="unavailable" name="status">
                                                        <button type="button"
                                                            class="dropdown-item  btn-status-product">Non Aktifkan Produk</button>
                                                    </form>
                                                @endif
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

    <div class="modal fade" id="modalInsertProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form method="POST" novalidate="novalidate" id="formInsertProduct" action="{{ route('product.store') }} "
                    enctype="multipart/form-data">
                    @csrf
                    @method('POST')
                    <div class="modal-header">
                        <h5 class="modal-title">Tambah Product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6">
                                @if (Request::segment(1) == 'product-ready')
                                    <input type="hidden" name="brand" value="product-ready">
                                @elseif (Request::segment(1) == 'barang-unik')
                                    <input type="hidden" name="brand" value="barang-unik">
                                @endif

                                <div class="form-group">
                                    <label for="insert_products_image text-center">Image</label>
                                    <div class="fileinput fileinput-new text-center d-block" data-provides="fileinput">
                                        <div class="fileinput-new thumbnail">
                                            <img src="{{ asset('dashboard') }}/img/image_placeholder.jpg" alt="...">
                                        </div>
                                        <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                        <div>
                                            <span class="btn btn-primary btn-link  btn-file">
                                                <span class="fileinput-new">Pilih Gambar</span>
                                                <span class="fileinput-exists">Ganti</span>
                                                <input type="file" name="image" maxsize="2" extension="jpg|gif|png|jpeg" required>
                                            </span>
                                            <a class="btn btn-danger btn-link fileinput-exists" data-dismiss="fileinput"><i
                                                    class="fa fa-times"></i> Remove</a>
                                        </div>
                                    </div>
                                    @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="insert_products_name">Name</label>
                                    <input type="text" name="name" value="{{ old('name') }}" id="insert_products_name"
                                        class="form-control" required="true" />
                                    @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                @if (Request::segment(1) == 'preorder')
                                    <input type="hidden" name="status" value="preorder">
                                    <div class="form-group">
                                        <label for="insert_products_brand">Brand</label>
                                        <div class="form-check form-check-radio pl-0">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="brand" id="insert_products_brand" value="product-ready" required="true">
                                                <span class="form-check-sign"></span>
                                                Produk Ready
                                            </label>
                                        </div>
                                        <div class="form-check form-check-radio pl-0">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="radio" name="brand" id="insert_products_brand" value="barang-unik" required="true">
                                                <span class="form-check-sign"></span>
                                                Barang Unik
                                            </label>
                                        </div>
                                        @error('brand')<small class="text-danger">{{ $message }}</small>@enderror
                                    </div>
                                @else
                                    <input type="hidden" name="status" value="available">
                                @endif

                                <div class="form-group">
                                    <label for="insert_products_price">Price</label>
                                    <input type="number" name="price" value="{{ old('price') }}" id="insert_products_price"
                                        class="form-control" required="true" />
                                    @error('price')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="insert_products_weight">Weight (Gram)</label>
                                    <input type="number" name="weight" value="{{ old('weight') }}" id="insert_products_weight" class="form-control" required="true" min="0"  />
                                    @error('weight')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                                <div class="form-group">
                                    <label for="insert_products_description">Description</label>
                                    <textarea name="description" id="insert_products_description" class="form-control" cols="30" rows="2"></textarea>
                                    @error('brand')<small class="text-danger">{{ $message }}</small>@enderror
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-12">
                                        <span class="d-block text-center font-weight-bold">
                                            Varian Produk
                                        </span>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 input-varian-container">
                                        <div class="row input-varian mb-2">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label >Varian Name</label>
                                                    <input type="text" name="product_varian_name[0]" value=""
                                                        class="form-control" required="true" />
                                                    @error('stock')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>
                                                <div class="form-group">
                                                    <label>Stock</label>
                                                    <input type="number" name="product_varian_stock[0]" value=""
                                                        class="form-control" required="true" min="0" />
                                                    @error('stock')<small class="text-danger">{{ $message }}</small>@enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <button class="btn btn-outline-primary tambah-varian" type="button">
                                            Tambah Varian
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Tambah product</button>
                        <button class="btn btn-outline-default" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalEditProduct" tabindex="-1" role="dialog" aria-labelledby="modelTitleId"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="POST" novalidate="novalidate" id="formEditProduct" action="" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title">Edit product</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id" value="{{ old('id') }}" />

                        <div class="form-group">
                            <label for="edit_products_image">Image</label>

                            <div class="fileinput fileinput-new text-center d-block" data-provides="fileinput">
                                <div class="fileinput-new thumbnail">
                                    <img src="" alt="...">
                                </div>
                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                <div>
                                    <span class="btn btn-primary btn-link  btn-file">
                                        <span class="fileinput-new">Edit Gambar</span>
                                        <span class="fileinput-exists">Ganti</span>
                                        <input type="file" name="image" maxsize="2" extension="jpg|gif|png|jpeg">
                                    </span>
                                    <a class="btn btn-danger btn-link fileinput-exists" data-dismiss="fileinput"><i
                                            class="fa fa-times"></i> Remove</a>
                                </div>
                            </div>
                            @error('image')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_products_name">Name</label>
                            <input type="text" name="name" value="{{ old('name') }}" id="edit_products_name"
                                class="form-control" required="true" />
                            @error('name')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_products_price">Price</label>
                            <input type="number" name="price" value="{{ old('price') }}" id="edit_products_price"
                                class="form-control" required="true" />
                            @error('price')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_products_weight">Weight (Gram)</label>
                            <input type="number" name="weight" value="{{ old('weight') }}" id="edit_products_weight" class="form-control" required="true" min="0"  />
                             @error('weight')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                        <div class="form-group">
                            <label for="edit_products_description">Description</label>
                            <textarea name="description" id="edit_products_description" class="form-control" cols="30" rows="2"></textarea>
                             @error('brand')<small class="text-danger">{{ $message }}</small>@enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-primary" type="submit">Edit product</button>
                        <button class="btn btn-outline-default" data-dismiss="modal">Tutup</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@push('js')

    <script>
        $(document).ready(function() {
            var tableProducts = $('#tableProducts').DataTable({
                "pagingType": "full_numbers",
                "lengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "columnDefs": [{
                        "width": "30%",
                        "targets": -1
                    },
                    {
                        "width": "5%",
                        "targets": 0
                    },
                    {
                        "width": "10%",
                        "targets": 3
                    }
                ],
                responsive: true,
                autoWidth: false
            });

            tableProducts.on('order.dt search.dt', function() {
                tableProducts.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });


        $('.btn-status-product').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            console.log(form)
            swal({
                title: 'Apakah Anda Yakin ?',
                text: "Status produk akan diganti !",
                type: 'warning',
                showCancelButton: true,
                confirmButtonClass: 'btn btn-info',
                cancelButtonClass: 'btn btn-default btn-link',
                confirmButtonText: 'Ya',
                buttonsStyling: false
            }).then(function(result) {
                if (result.value === true) {
                    $(form).submit();
                }
            })
        });

        $('.btn-delete-product').on('click', function(e) {
            e.preventDefault();
            var form = $(this).parents('form');
            swal({
                title: 'Apakah Anda Yakin ?',
                text: "Data product akan dihapus dan tidak dapat dikembalikan !",
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


        app.setFormValidation('#formInsertProduct');

        app.setFormValidation('#formEditProduct');

        function openModalEditProduct($getUrl, $updateUrl) {
            $.getJSON($getUrl,
                function(data, textStatus, jqXHR) {
                    $('#formEditProduct .form-group').addClass('is-filled');
                    $('#formEditProduct [name="id"]').val(data.id);
                    $('#formEditProduct [name="name"]').val(data.name);
                    $('#formEditProduct [name="price"]').val(data.price);
                    $('#formEditProduct [name="description"]').val(data.description);
                    $('#formEditProduct [name="weight"]').val(data.weight);
                    $('#formEditProduct').attr('action', $updateUrl);
                    $('#formEditProduct .fileinput img').attr('src', data.image_url);
                    $('#modalEditProduct').modal('show');
                }
            );
        }

        $('.tambah-varian').on('click', function(){
            $element_index = $(".input-varian").length;
            $cloned_element = $(".input-varian").first().clone();
            $cloned_element.appendTo(".input-varian-container");

            $cloned_element.find('[name="product_varian_name[0]"]').attr("name", "product_varian_name["+$element_index+"]").val("").focus();
            $cloned_element.find('[name="product_varian_stock[0]"]').attr("name", "product_varian_stock["+$element_index+"]").val("");
        })
    </script>



@endpush
