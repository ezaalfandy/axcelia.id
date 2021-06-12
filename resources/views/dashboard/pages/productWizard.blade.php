@extends('dashboard.layouts.app')
@section('main')
    <div class="col-md-10 mr-auto ml-auto">
        <div class="wizard-container">
            <div class="card card-wizard" data-color="primary" id="wizardProfile">
                <form method="POST" novalidate="novalidate" id="formInsertProducts"
                    action="{{ route('product.store') }} " enctype="multipart/form-data">
                    @csrf
                    <div class="card-header text-center" data-background-color="primary">
                        <h3 class="card-title mb-3 text-uppercase font-weight-bold">
                            Input Produk Baru
                        </h3>
                        <div class="wizard-navigation">
                            <ul class="nav nav-pills">
                                <li class="nav-item">
                                    <a class="nav-link active" href="#judulGambar" data-toggle="tab" role="tab"
                                        aria-controls="about" aria-selected="true">
                                        Judul dan Gambar
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#warna" data-toggle="tab" data-toggle="tab" role="tab"
                                        aria-controls="warna" aria-selected="false">
                                        Varian Warna
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="#VarianUkuran" data-toggle="tab" data-toggle="tab" role="tab"
                                        aria-controls="VarianUkuran" aria-selected="false">
                                        Varian Ukuran
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane show active" id="judulGambar">
                                <div class="row justify-content-center">
                                    <div class="col-md-10">
                                        <div class="form-group">
                                            <label for="insert_products_merek">Merek</label>
                                            <select name="merek" name="merek" id="insert_products_merek" class="selectpicker w-100"
                                                value="{{ old('merek') }}" required="true" type="dropdown"
                                                data-style="select-with-transition form-control">
                                                <option value="joemen">Joemen</option>
                                                <option value="aloppe">Aloppe</option>
                                            </select>
                                            @error('merek')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="insert_products_nama_produk">Nama Produk</label>
                                            <input type="text" name="nama_produk" value="{{ old('nama_produk') }}"
                                                id="insert_products_nama_produk" class="form-control" required="true" />
                                            @error('nama_produk')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="insert_products_harga">Harga</label>
                                            <input type="number" name="harga" value="{{ old('harga') }}"
                                                id="insert_products_harga" class="form-control" required="true" />
                                            @error('harga')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="insert_products_berat">Berat (Gram)</label>
                                            <input type="number" name="berat" value="700"
                                                id="insert_products_berat" class="form-control" required="true" min="0"/>
                                            @error('berat')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-group">
                                            <label for="insert_products_thumbnail">Thumbnail</label>
                                            <div class="fileinput fileinput-new text-center d-block" data-provides="fileinput">
                                                <div class="fileinput-new thumbnail">
                                                    <img src="{{ asset('dashboard') }}/img/image_placeholder.jpg" alt="...">
                                                </div>
                                                <div class="fileinput-preview fileinput-exists thumbnail"></div>
                                                <div>
                                                    <span class="btn btn-primary btn-link  btn-file">
                                                        <span class="fileinput-new">Pilih Gambar</span>
                                                        <span class="fileinput-exists">Ganti</span>
                                                        <input type="file" name="thumbnail" maxsize="2"
                                                            extension="jpg|gif|png|jpeg" required="true">
                                                    </span>
                                                    <a class="btn btn-danger btn-link fileinput-exists" data-dismiss="fileinput"><i
                                                            class="fa fa-times"></i> Remove</a>
                                                </div>
                                            </div>
                                            @error('thumbnail')<small class="text-danger">{{ $message }}</small>@enderror
                                        </div>
                                        <div class="form-group form-file-upload form-file-multiple">
                                            <label for="insert_products_images">Gambar Produk</label>
                                            <input type="file" id="insert_products_images" multiple="" class="inputFileHidden" required="true" name="gambar[]">
                                            <input type="text" class="form-control inputFileVisible" placeholder="Gambar Produk" multiple="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="warna">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10">
                                        <div class="row kelompok_warna">
                                            <div class="col-md-12 input_warna">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <label for="insert_product_varians_warna">Warna</label>
                                                            <input type="text" name="warna[]" value="{{ old('warna') }}" id="insert_product_varians_warna" class="form-control" required="true"  />
                                                             @error('warna')<small class="text-danger">{{ $message }}</small>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn mt-4 btn-outline-danger remove_input_warna">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10 text-center">
                                        <button class="btn btn-outline-primary mt-3 mb-5" onclick="tambah_warna()" type="button">
                                        Tambah Warna
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="VarianUkuran">
                                <div class="row justify-content-center">
                                    <div class="col-lg-10">
                                        <div>
                                            Ukuran
                                        </div>
                                    </div>
                                    <div class="col-lg-10">
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="ukuran[]" value="39">
                                                <span class="form-check-sign"></span>
                                                39
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="ukuran[]" value="40">
                                                <span class="form-check-sign"></span>
                                                40
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="ukuran[]" value="41">
                                                <span class="form-check-sign"></span>
                                                41
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="ukuran[]" value="42">
                                                <span class="form-check-sign"></span>
                                                42
                                            </label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <label class="form-check-label">
                                                <input class="form-check-input" type="checkbox" name="ukuran[]" value="43">
                                                <span class="form-check-sign"></span>
                                                43
                                            </label>
                                        </div>
                                        <div class="form-check mt-2 pl-0">
                                            <label class="form-check-label">
                                                <input class="form-check-input pilih-semua-ukuran" type="checkbox">
                                                <span class="form-check-sign"></span>
                                                (pilih semua)
                                            </label>
                                        </div>
                                        <p class="mt-3">Input ukuran kustom</p>
                                        <div class="row kelompok_ukuran mt-2">
                                            <div class="col-md-12 input_ukuran">
                                                <div class="row">
                                                    <div class="col-md-10">
                                                        <div class="form-group">
                                                            <input type="text" name="ukuran[]" value="{{ old('ukuran') }}" id="insert_product_varians_ukuran" class="form-control"/>
                                                             @error('ukuran')<small class="text-danger">{{ $message }}</small>@enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn m-0 btn-outline-danger remove_input_ukuran">
                                                            Hapus
                                                        </button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-10 text-center">
                                        <button class="btn btn-outline-primary mt-3 mb-5" onclick="tambah_ukuran()" type="button">
                                        Tambah Ukuran
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="pull-right">
                            <input type='button' class='btn btn-next btn-fill btn-primary btn-wd' name='next' value='Next' />
                            <input type='submit' class='btn btn-finish btn-fill btn-primary btn-wd' name='finish'
                                value='Finish' />
                        </div>
                        <div class="pull-left">
                            <input type='button' class='btn btn-previous btn-outline-primary' name='previous'
                                value='Previous' />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </form>
            </div>
        </div> <!-- wizard container -->
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $validator = app.setFormValidation('#formInsertProducts');
            app.initNowUiWizard($validator);
            setTimeout(function() {
                $('.card.card-wizard').addClass('active');
            }, 600);

            $('.pilih-semua-ukuran').on('change', function (e) {
                if($(this).first().is(':checked') == true){
                    $('[name="ukuran[]"]').prop('checked', true);
                }else{
                    $('[name="ukuran[]"]').prop('checked', false);
                }
            });

            $('#formInsertProducts').on('click', '.remove_input_warna', function()
                {
                    if($('.input_warna').length > 1)
                    {
                        $(this).parents('.input_warna').fadeOut(function()
                        {
                            $(this).remove();
                        })
                    }
                }
            )

            $('#formInsertProducts').on('click', '.remove_input_ukuran', function()
                {
                    if($('.input_ukuran').length > 1)
                    {
                        $(this).parents('.input_ukuran').fadeOut(function()
                        {
                            $(this).remove();
                        })
                    }
                }
            )
        });

        function tambah_warna()
        {
            $element_index = $(".input_warna").length;
            $cloned_element = $(".input_warna").first().clone();
            $cloned_element.appendTo( ".kelompok_warna");

            $cloned_element.find('[name="warna[]"]').attr("name", "warna["+$element_index+"]").val(null);
            $cloned_element.find('[name="warna['+$element_index+']"]').focus();
        }

        function tambah_ukuran()
        {
            $element_index = $(".input_ukuran").length;
            $cloned_element = $(".input_ukuran").first().clone();
            $cloned_element.appendTo( ".kelompok_ukuran");

            $cloned_element.find('[name="ukuran[]"]').attr("name", "ukuran["+$element_index+"]").val(null);
            $cloned_element.find('[name="ukuran['+$element_index+']"]').focus();
        }
    </script>
@endpush
