<div class="sidebar">
    <div class="sidebar-wrapper">
        <div class="logo">
            <a href="#" class="simple-text logo-mini">{{ __('AR') }}</a>
            <a href="#" class="simple-text logo-normal">{{ __('Artha Royal') }}</a>
        </div>
        <ul class="nav">
            <li>
                <a href="{{ route('home') }}">
                    <i class="tim-icons icon-chart-pie-36"></i>
                    <p>{{ __('Dashboard') }}</p>
                </a>
            </li>
            <li>
                <a data-toggle="collapse" href="#laravel-examples" aria-expanded="false">
                    <i class="tim-icons icon-single-02"></i>
                    <span class="nav-link-text">{{ __('Master') }}</span>
                    <b class="caret mt-1"></b>
                </a>

                <div class="collapse" id="laravel-examples">
                    <ul class="nav pl-4">
                        <li>
                            <a href="{{ route('user.index') }}">
                                <i class="tim-icons icon-bullet-list-67"></i>
                                <p>{{ __('User Management') }}</p>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('mobil.index') }}">
                                <i class="tim-icons icon-bus-front-12"></i>
                                <p>{{ __('Mobil Management') }}</p>
                            </a>
                        </li>
                    </ul>
                </div>
            </li>

            <li>
                <a href="{{ route('pemesanan.index') }}">
                    <i class="tim-icons icon-cart"></i>
                    <p>{{ __('Pemesanan') }}</p>
                </a>
            </li>


            <li>
                <a data-toggle="collapse" href="#laravel-exampless" aria-expanded="false">
                    <i class="tim-icons icon-coins"></i>
                    <span class="nav-link-text">{{ __('Laporan') }}</span>
                    <b class="caret mt-2"></b>
                </a>

                <div class="collapse" id="laravel-exampless">
                    <ul class="nav pl-4">
                        <li>
                            <a href="{{ route('pendapatan.index') }}">
                                <i class="tim-icons icon-paper"></i>
                                <p>{{ __('Pendapatan') }}</p>
                            </a>
                        </li>

                    </ul>
                </div>
            </li>


        </ul>
    </div>
</div>
