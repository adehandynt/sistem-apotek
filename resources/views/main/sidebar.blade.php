<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">
            <img src="../assets/images/users/user-1.jpg" alt="user-img" title="Mat Helme"
                class="rounded-circle avatar-md">
            <div class="dropdown">
                <a href="javascript: void(0);" class="text-dark dropdown-toggle h5 mt-2 mb-1 d-block"
                    data-bs-toggle="dropdown">Anne </a>
                <div class="dropdown-menu user-pro-dropdown">

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-user me-1"></i>
                        <span>My Account</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-settings me-1"></i>
                        <span>Settings</span>
                    </a>

                    <!-- item-->
                    <a href="javascript:void(0);" class="dropdown-item notify-item">
                        <i class="fe-lock me-1"></i>
                        <span>Lock Screen</span>
                    </a>

                    <!-- item-->
                    <a href="/logout" class="dropdown-item notify-item">
                        <i class="fe-log-out me-1"></i>
                        <span>Logout</span>
                    </a>

                </div>
            </div>
            <p class="text-muted">Owner</p>
        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">
                @if(session('position')=='manager' ||session('position')=='owner')
                <li class="menu-title mt-2">Dashboard</li>
                <li>
                    <a href="/dashboard">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>
                @endif
                @if(session('position')=='owner'|| session('position')=='manager' || session('position')=='apoteker')
                <li class="menu-title mt-2">Pembelian</li>
                <li>
                    <a href="#sidebarPembelian" data-bs-toggle="collapse">
                        <i class="mdi mdi-cart-outline"></i>
                        <span class="menu-arrow"></span>
                        <span> Pembelian</span>
                    </a>
                    <div class="collapse" id="sidebarPembelian">
                        <ul class="nav-second-level">
                            <li>
                                <a href="/pembelian">Daftar Pembelian</a>
                            </li>
                            <li>
                                <a href="/retur-pembelian">Retur pembelian</a>
                            </li>
                        </ul>
                    </div>
                </li>@endif
                @if(session('position')=='manager' ||session('position')=='owner')
                <li class="menu-title mt-2">Pembayaran</li>
                <li>
                    <a href="pembayaran">
                        <i class="mdi mdi-cash-minus"></i>
                        <span> Pembayaran </span>
                    </a>
                </li>
                @endif
                @if(session('position')=='manager' ||session('position')=='owner' || session('position')=='ass_apoteker' || session('position')=='apoteker'|| session('position')=='kasir')
                <li class="menu-title mt-2">Penjualan</li>
                <li>
                    <a href="#sidebarPenjualan" data-bs-toggle="collapse">
                        <i class="mdi mdi-cash-register"></i>
                        <span class="menu-arrow"></span>
                        <span> Penjualan</span>
                    </a>
                    <div class="collapse" id="sidebarPenjualan">
                        <ul class="nav-second-level">
                            <li>
                                GUNAKAN FITUR PENJUALAN PADA URL " 127.0.0.1:8000 "
                            </li>
                            {{-- <li>
                                <a href="/penjualan">Penjualan</a>
                            </li>--}}
                            <li>
                                <a href="/retur-penjualan">Retur Penjualan</a>
                            </li> 
                        </ul>
                    </div>
                </li>
                 @endif
                @if(session('position')=='owner' || session('position')=='manager' || session('position')=='ass_apoteker' || session('position')=='apoteker')
                <li class="menu-title mt-2">Stock</li>
                <li>
                    <a href="#sidebarStock" data-bs-toggle="collapse">
                        <i class="mdi mdi-medical-bag"></i>
                        <span class="menu-arrow"></span>
                        <span> Stock</span>
                    </a>
                    <div class="collapse" id="sidebarStock">
                        <ul class="nav-second-level">
                            {{-- <li>
                                <a href="reorder">Re-Order Point</a>
                            </li> --}}
                            <li>
                                <a href="stock">Stock Obat / Barang</a>
                            </li>
                            <li>
                                <a href="stock-opname">Stock Opname</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if(session('position')=='owner' || session('position')=='manager')
                <li class="menu-title mt-2">Laporan</li>
                <li>
                    <a href="#sidebarDashboards" data-bs-toggle="collapse">
                        <i class="mdi mdi-file-document"></i>
                        <span class="menu-arrow"></span>
                        <span> Laporan </span>
                    </a>
                    <div class="collapse" id="sidebarDashboards">
                        <ul class="nav-second-level">
                            <li>
                                <a href="/laporan-laba-rugi">Laba Rugi</a>
                            </li>
                            <li>
                                <a href="/laporan-narkotika">Obat Narkotika</a>
                            </li>
                            <li>
                                <a href="/laporan-bpjs">Laporan BPJS</a>
                            </li>
                            <li>
                                <a href="/laporan-konsinyasi">Konsinyasi</a>
                            </li>
                            <li>
                                <a href="/laporan-penjualan">Penjualan</a>
                            </li>
                            <li>
                                <a href="/laporan-pembelian">Pembelian</a>
                            </li>
                        </ul>
                    </div>
                </li>@endif
                @if(session('position')=='dokter' || session('position')=='manager'|| session('position')=='owner' )
                <li class="menu-title mt-2">Dokter</li>
                <li>
                    <a href="#sidebarDataDokter" data-bs-toggle="collapse">
                        <i class="mdi mdi-database-outline"></i>
                        <span class="menu-arrow"></span>
                        <span> Dokter </span>
                    </a>
                    <div class="collapse" id="sidebarDataDokter">
                        <ul class="nav-second-level">
                            <li>
                                <a href="/data-antrian">Antrian</a>
                            </li>
                            <li>
                                <a href="/data-pasien">Pasien</a>
                            </li>
                            <li>
                                <a href="/data-medis">Rekam Medis</a>
                            </li>
                            <li>
                                <a href="/data-obat">Data Obat</a>
                            </li>
                            <li>
                                <a href="/data-tindakan">Data Tindakan</a>
                            </li>
                            <li>
                                <a href="/data-penyakit">Data Penyakit</a>
                            </li>
                        </ul>
                    </div>
                </li>@endif
                @if(session('position')!='kasir' && session('position')!='dokter')
                <li class="menu-title mt-2">Data Master</li>
                <li>
                    <a href="#sidebarDataMaster" data-bs-toggle="collapse">
                        <i class="mdi mdi-database-outline"></i>
                        <span class="menu-arrow"></span>
                        <span> Data Master </span>
                    </a>
                    <div class="collapse" id="sidebarDataMaster">
                        <ul class="nav-second-level">
                            <li>
                                <a href="/data-barang">Barang</a>
                            </li>
                            <li>
                                <a href="/data-tipe">Tipe</a>
                            </li>
                            <li>
                                <a href="/data-satuan">Satuan</a>
                            </li>
                            <li>
                                <a href="/data-jasa">Jasa</a>
                            </li>
                            <li>
                                <a href="/data-margin">Margin</a>
                            </li>
                            @if(session('position')=='manager'|| session('position')=='owner' )
                            <li>
                                <a href="/data-pasien">Pasien</a>
                            </li>
                            <li>
                                <a href="/data-akun">Akun</a>
                            </li>
                            <li>
                                <a href="/data-staf">Staf</a>
                            </li>
                            @endif
                            <li>
                                <a href="/data-supplier">Supplier</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
                @if(session('position')!='dokter')
                <li class="menu-title mt-2">User Manual</li>
                <li>
                    <a href="#sidebarUserManual" data-bs-toggle="collapse">
                        <i class="mdi mdi-help-circle-outline"></i>
                        <span class="menu-arrow"></span>
                        <span> User Manual </span>
                    </a>
                    <div class="collapse" id="sidebarUserManual">
                        <ul class="nav-second-level">
                            <li>
                                <a href="/user-manual">Manual</a>
                            </li>
                        </ul>
                    </div>
                </li>
                @endif
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->
    @if (Auth::check()) 
    <script>
    var timeout = ({{config('session.lifetime')}} * 60000) -10 ;
    setTimeout(function(){
        window.location.reload(1);
    },  timeout);

    </script>
@endif
</div>