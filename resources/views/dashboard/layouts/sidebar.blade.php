<div class="sidebar" data-color="primary">
    <div class="logo">
        <a href="http://www.creative-tim.com" class="simple-text logo-mini">
            AX
        </a>
        <a href="http://www.creative-tim.com" class="simple-text logo-normal">
            Axcelia
        </a>
        <div class="navbar-minimize">
            <button id="minimizeSidebar" class="btn btn-outline-white btn-icon btn-round">
                <i class="now-ui-icons text_align-center visible-on-sidebar-regular"></i>
                <i class="now-ui-icons design_bullet-list-67 visible-on-sidebar-mini"></i>
            </button>
        </div>
    </div>
    <div class="sidebar-wrapper" id="sidebar-wrapper">
        <div class="user">
            <div class="info">
                <a data-toggle="collapse" href="#collapseExample" class="collapsed">
                    <span>
                        {{ auth()->user()->name }}
                        <b class="caret"></b>
                    </span>
                </a>
                <div class="clearfix"></div>
                <div class="collapse" id="collapseExample">
                    <ul class="nav">
                        <li>
                            <a href="#">
                                <span class="sidebar-mini-icon">MP</span>
                                <span class="sidebar-normal">My Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="sidebar-mini-icon">EP</span>
                                <span class="sidebar-normal">Edit Profile</span>
                            </a>
                        </li>
                        <li>
                            <a href="#">
                                <span class="sidebar-mini-icon">S</span>
                                <span class="sidebar-normal">Settings</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <ul class="nav">
            <li>
                <a href="../../examples/dashboard.html">
                    <i class="now-ui-icons design_app"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            <li @if (Request::segment(1) == 'axcelia' || Request::segment(1) == 'mooncarla' || Request::segment(1) == 'preorder') class="active" @endif>
                <a data-toggle="collapse" href="#produk" class="collapsed" aria-expanded="false">
                    <i class="now-ui-icons shopping_box"></i>
                    <p>
                        Produk <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="produk" style="">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('product.axcelia') }}">
                                <span class="sidebar-mini-icon">AX</span>
                                <span class="sidebar-normal">Axcelia</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('product.mooncarla') }}">
                                <span class="sidebar-mini-icon">MC</span>
                                <span class="sidebar-normal">Mooncarla</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('product.preorder') }}">
                                <span class="sidebar-mini-icon">PR</span>
                                <span class="sidebar-normal">Pre order</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('product.non-active') }}">
                                <span class="sidebar-mini-icon">NA</span>
                                <span class="sidebar-normal">Non Aktif</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
            <li @if (Request::segment(1) == 'user-approved' || Request::segment(1) == 'user-waiting') class="active" @endif>
                <a data-toggle="collapse" href="#pelanggan" class="collapsed" aria-expanded="false">
                    <i class="now-ui-icons users_single-02"></i>
                    <p>
                        Pelanggan <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="pelanggan" style="">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('user.approved') }}">
                                <span class="sidebar-mini-icon">AP</span>
                                <span class="sidebar-normal">Approved</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('user.waiting') }}">
                                <span class="sidebar-mini-icon">WA</span>
                                <span class="sidebar-normal">Waiting</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li @if (Request::segment(1) == 'purchase-waiting' || Request::segment(1) == 'purchase-complete') class="active" @endif>
                <a data-toggle="collapse" href="#order" class="collapsed" aria-expanded="false">
                    <i class="now-ui-icons shopping_cart-simple"></i>
                    <p>
                        Daftar Order <b class="caret"></b>
                    </p>
                </a>
                <div class="collapse" id="order" style="">
                    <ul class="nav">
                        <li>
                            <a href="{{ route('purchase.index') }}">
                                <span class="sidebar-mini-icon">OM</span>
                                <span class="sidebar-normal">Order Masuk</span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('purchase.complete') }}">
                                <span class="sidebar-mini-icon">OS</span>
                                <span class="sidebar-normal">Order Selesai</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>
