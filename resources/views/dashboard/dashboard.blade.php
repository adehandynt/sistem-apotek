@extends('main/app')
@section('content')
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">

            <div class="row mt-3">
                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card bg-pattern">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded bg-soft-info">
                                        <i class="dripicons-wallet font-24 avatar-title text-info"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1">Rp <span data-plugin="counterup">{{number_format(($penjualan[0]->penjualan-$penjualan[0]->retur),2)}}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Pendapatan, Hari ini</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card bg-pattern">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded bg-soft-primary">
                                        <i class="dripicons-basket font-24 avatar-title text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{number_format($terjual[0]->terjual,0)}}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Produk Terjual, Hari ini</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card bg-pattern">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded bg-soft-primary">
                                        <i class="dripicons-user-group font-24 avatar-title text-primary"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{number_format($pasien[0]->pasien,0)}}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Pasien, Hari ini</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->

                <div class="col-md-6 col-xl-3">
                    <div class="widget-rounded-circle card bg-pattern">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="avatar-lg rounded bg-soft-danger">
                                        <i class="dripicons-cross font-24 avatar-title text-danger"></i>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-end">
                                        <h3 class="text-dark mt-1"><span data-plugin="counterup">{{number_format($kadaluwarsa[0]->kadaluwarsa,0)}}</span></h3>
                                        <p class="text-muted mb-1 text-truncate">Produk Kadaluwarsa</p>
                                    </div>
                                </div>
                            </div> <!-- end row-->
                        </div>
                    </div> <!-- end widget-rounded-circle-->
                </div> <!-- end col-->
    
            </div>
            <!-- end row -->
            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Pendapatan Staf Hari Ini</h4>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-hover mb-0" id="pendapatan-datatables">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">NIP</th>
                                            <th class="border-top-0">Nama Staf</th>
                                            <th class="border-top-0">Pendapatan</th>
                                            <th class="border-top-0">Retur</th>
                                            <th class="border-top-0">Total Pendapatan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if(count($pendapatan_staf)<1)
                                        <tr>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                            <td>
                                                -
                                            </td>
                                        </tr>
                                            @endif
                                        @foreach ($pendapatan_staf as $key => $val)
                                        <tr>
                                            <td>
                                                <span class="ms-2">{{$val->nip}}</span>
                                            </td>
                                            <td>
                                                <span class="ms-2">{{$val->nama_staf}}</span>
                                            </td>
                                            <td>
                                                <span class="ms-2">Rp {{number_format($val->pendapatan,2)}}</span>
                                            </td>
                                            <td>
                                                <span class="ms-2">Rp {{number_format($val->retur,2)}}</span>
                                            </td>
                                            <td>
                                                <span class="ms-2"><b>Rp {{number_format($val->pendapatan-$val->retur,2)}}</b></span>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive -->
                        </div>
                    </div> <!-- end card-->
                </div>
            </div>

            <div class="row">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body pb-2">
                            <div class="float-end d-none d-md-inline-block">
                                {{-- <div class="btn-group mb-2">
                                    <button type="button" class="btn btn-xs btn-light">Today</button>
                                    <button type="button" class="btn btn-xs btn-light">Weekly</button>
                                    <button type="button" class="btn btn-xs btn-secondary">Monthly</button>
                                </div> --}}
                            </div>

                            <h4 class="header-title mb-3">Penjualan</h4>

                            <div class="row text-center">
                                <div class="col-md-4">
                                    <p class="text-muted mb-0 mt-3">Bulan Ini</p>
                                    <h2 class="fw-normal mb-3">
                                        <small class="mdi mdi-checkbox-blank-circle text-primary align-middle me-1"></small>
                                        @if(count($sekarang)==0)
                                        <span alt="0">Rp 0</span>
                                        @endif
                                        @foreach ($sekarang as $key => $val)
                                        <span>Rp {{number_format($val->total,2)}}</span>
                                        @endforeach
                                    </h2>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted mb-0 mt-3">Bulan Lalu</p>
                                    <h2 class="fw-normal mb-3">
                                        <small class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                        @if(count($lalu)==0)
                                        <span alt="0">Rp 0</span>
                                        @endif
                                        @foreach ($lalu as $key => $val)
                                        <span alt="0">Rp {{number_format($val->total,2)}}</span>
                                        @endforeach
                                    </h2>
                                </div>
                                <div class="col-md-4">
                                    <p class="text-muted mb-0 mt-3">Target</p>
                                    <h2 class="fw-normal mb-3">
                                        <small class="mdi mdi-checkbox-blank-circle text-success align-middle me-1"></small>
                                        @if($rata==0)
                                        {{-- <span alt="0">Rp 0</span> --}}
                                        @endif
                                      
                                        <span alt="0">Rp {{number_format($rata,2)}}</span>
                               
                                    </h2>
                                </div>
                            </div>
                            
                            <div id="revenue-chart" class="apex-charts mt-3" data-colors="#7e57c2,#4fc6e1"></div>
                        </div>
                    </div> <!-- end card -->
                </div> <!-- end col-->

            </div>
            <!-- end row -->


            <div class="row">
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">History Penjualan</h4>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-hover mb-0" id="basic-datatables">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">No. Transaksi</th>
                                            <th class="border-top-0">Pembayaran</th>
                                            <th class="border-top-0">Tanggal</th>
                                            <th class="border-top-0">Total</th>
                                            <th class="border-top-0">Status</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($produk as $key => $val)
                                        <tr>
                                            <td>
                                                <span class="ms-2">{{$val->no_transaksi}}</span>
                                            </td>
                                            @if($val->metode_pembayaran == "bpjs")
                                            <td>
                                                <img src="../assets/images/cards/bpjs.jpg" alt="user-card" height="24" />
                                                <span class="ms-2">{{$val->bpjs}}</span>
                                            </td>
                                            @elseif($val->metode_pembayaran == "debitkredit")
                                            <td>
                                                <img src="../assets/images/cards/master.png" alt="-" height="24" />
                                                <span class="ms-2">{{$val->no_kartu}}</span>
                                            </td>
                                            @else
                                            <td>
                                                <span class="ms-2">TUNAI</span>
                                            </td>
                                            @endif
                                            <td>{{$val->tgl_transaksi}}</td>
                                            <td>Rp {{number_format($val->total,2)}}</td>
                                            @if($val->metode_pembayaran != "bpjs")
                                            <td><span class="badge rounded-pill bg-success">LUNAS</span></td>
                                            @else
                                            <td><span class="badge rounded-pill bg-warning">BPJS</span></td>
                                            @endif
                                            <td>
                                                <button class="btn btn-xs btn-danger btn-hapus-transaksi" data-id="{{$val->no_transaksi}}" >Hapus</button>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive -->
                        </div>
                    </div> <!-- end card-->
                </div>
              
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Produk Terlaris</h4>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-hover mb-0" id="terlaris-datatables">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">Produk</th>
                                            <th class="border-top-0">Sisa</th>
                                            <th class="border-top-0">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($terlaris as $key => $val)
                                        <tr>
                                            <td>
                                                <span class="ms-2">{{$val->nama_barang}}</span>
                                            </td>
                                            <td>{{$val->sisa}}</td>
                                            @if($val->sisa <= 30 && $val->sisa >= 1)
                                            <td><span class="badge bg-soft-warning text-warning">Hampir Habis</span></td>
                                            @elseif($val->sisa<=0)
                                            <td><span class="badge bg-soft-danger text-danger">Habis</span></td>
                                            @else 
                                            <td><span class="badge bg-soft-success text-success">Tersedia</span></td>
                                            @endif
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive -->
                        </div>
                    </div> <!-- end card-->
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Piutang Penjualan</h4>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-hover mb-0" id="piutang-datatables">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">No. Transaksi</th>
                                            <th class="border-top-0">Tanggal</th>
                                            <th class="border-top-0">Total</th>
                                            <th class="border-top-0">Status</th>
                                            <th class="border-top-0">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($piutang as $key => $val)
                                        <tr>
                                            <td>
                                                <span class="ms-2">{{$val->no_transaksi}}</span>
                                            </td>
                                          
                                            <td>{{$val->tgl_transaksi}}</td>
                                            <td>Rp {{number_format($val->total,2)}}</td>
                                            @if($val->status_transaksi != "piutang")
                                            <td><span class="badge rounded-pill bg-success">LUNAS</span></td>
                                            @else
                                            <td><span class="badge rounded-pill bg-warning">BELUM LUNAS</span></td>
                                            @endif
                                            <td><button class="btn btn-xs btn-success btn-lunas" data-id="{{$val->no_transaksi}}" >Set Lunas</button></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive -->
                        </div>
                    </div> <!-- end card-->
                </div>
                <div class="col-xl-6">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title mb-3">Barang Kadaluwarsa</h4>

                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-hover mb-0" id="kadaluwarsa-datatables">
                                    <thead>
                                        <tr>
                                            <th class="border-top-0">Kode Barang</th>
                                            <th class="border-top-0">Nama Barang</th>
                                            <th class="border-top-0">Tanggal Kadaluwarsa</th>
                                            <th class="border-top-0">Nomor Order</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($expiredlist as $key => $val)
                                        <tr>
                                            <td>
                                                <span class="ms-2">{{$val->kode_barang}}</span>
                                            </td>
                                            <td>
                                                <span class="ms-2">{{$val->nama_barang}}</span>
                                            </td>
                                            <td>
                                                <span class="ms-2">{{$val->tgl_exp}}</span>
                                            </td>
                                            <td>
                                                <span class="ms-2">{{$val->id_order}}</span>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- end table-responsive -->
                        </div>
                    </div> <!-- end card-->
                </div> <!-- end col-->
                 <!-- end col-->
                <!-- end col-->
            </div>
            <!-- end row-->
            
        </div> <!-- container -->

    </div> <!-- content -->

    <!-- Footer Start -->
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <script>document.write(new Date().getFullYear())</script> &copy; Apotek Sindangsari Farma 
                </div>
                <div class="col-md-6">
                    <div class="text-md-end footer-links d-none d-sm-block">
                        <a href="javascript:void(0);">About Us</a>
                        <a href="javascript:void(0);">Help</a>
                        <a href="javascript:void(0);">Contact Us</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->

</div>
@endsection
@section('script')
<script src="../assets/libs/apexcharts/apexcharts.min.js"></script>


<script>
$('#basic-datatables').DataTable();
$('#piutang-datatables').DataTable();
$('#kadaluwarsa-datatables').DataTable();
$('#terlaris-datatables').DataTable();
$(document).ready(function() {
    drawGraph("");
    getPenjualan();
    $(".apexcharts-canvas").remove();
});
function getPenjualan() {
	    $.ajax({
	        url: "{{url('graph-data')}}",
	        type: "GET",
	        dataType: "json",
	        data: "",
	        timeout: 120000,
	        success: function (response){
                console.log(response);
	            drawGraph(response);
	        }
	    });
	}
function drawGraph(response){
    var options = {
			chart: {
				type: "line",
				stacked: false,
				height: 350,
				toolbar: {
	                show: false,
	            },
			},
			dataLabels: {
				enabled: false,
			},
			series: response.series !== undefined || response.series !== null? response.series:[],
			markers: {
				size: 3
			},legend: {
		    	show: true,
		    	labels: {
					colors: 'rgb(55, 61, 63)',
					useSeriesColors: false
				}
		    },
			yaxis: {
				labels: {
				show: true,
	                style: {
	                    fontSize: 9,
                        colors: 'rgb(55, 61, 63)'
	                }
				}
			},
			xaxis: {
				categories: response.labels !== undefined || response.series !== null? response.labels:[],
				labels: {
	                show: true,
	                style: {
	                    fontSize: 9,
	                    colors: 'rgb(55, 61, 63)'
	                }
	            }
			},

			tooltip: {
				enabled: true,
			},
				noData: {
					text: "Data Tidak Tersedia",
					align: "center",
					verticalAlign: "middle"
				}
			}
    
            var chart = new ApexCharts(document.querySelector("#revenue-chart"), options);
            chart.render();
}


$('#piutang-datatables tbody').on('click', '.btn-lunas', function() {
            var id = $(this).data("id");
            swal.fire({
                    title: "Anda Yakin?",
                    text: "Data yang di set LUNAS ( "+id+" ) tidak dapat dikembalikan",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Mengerti!",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    e.value ?
                        $.ajax({
                            type: "POST",
                            url: '/set-lunas',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            }
                        }).done(function(msg) {
                            
                            if (msg != 'error') {
                                swal.fire("Transaksi Telah Lunas !", {
                                    icon: "success",
                                });
                                location.reload();
                            } else {
                                swal.fire("Transaksi Gagal", {
                                    icon: "error",
                                });
                            }
                        })

                        :
                        swal.fire("Transaksi Dibatalkan !");

                });

        });

        $('#basic-datatables tbody').on('click', '.btn-hapus-transaksi', function() {
            var id = $(this).data("id");
            swal.fire({
                    title: "Anda Yakin?",
                    text: "Data yang di HAPUS tidak dapat dikembalikan",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Mengerti!",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    e.value ?
                        $.ajax({
                            type: "POST",
                            url: '/hapus-transaksi',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            }
                        }).done(function(msg) {
                            
                            if (msg != 'error') {
                                swal.fire("Transaksi Telah Dihapus !", {
                                    icon: "success",
                                });
                                location.reload();
                            } else {
                                swal.fire("Transaksi Gagal Dihapus", {
                                    icon: "error",
                                });
                            }
                        })

                        :
                        swal.fire("Hapus Transaksi Dibatalkan !");

                });

        });
</script>
@endsection