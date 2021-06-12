<a href="">
    <div class="card card-product shadow-sm">
        <div class="card-image">
            <img src="{{ asset('storage/product/thumbnail/'.$product->thumbnail) }}" alt="{{ $product->nama_produk}}" class="img-fluid">
        </div>
        <div class="card-body py-2">
            <h4 class="card-title text-left">{{ $product->nama_produk}}</h4>
            <div class="card-footer row">
                <div class="col-12 col-md-6">
                    <p class="price text-danger font-weight-bold mt-2">Rp {{ $product->harga}}</p>
                </div>
                <div class="col-12 col-md-6 add-to-cart">
                    <button class="btn btn-primary btn-neutral btn-icon" rel="tooltip" title="" data-placement="bottom" data-original-title="Tambahkan ke keranjang">
                        <i class="now-ui-icons shopping_cart-simple"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

</a>
