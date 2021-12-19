@extends('main/app')
@section('content')
<div class="content-page">
    <div class="content">

        <!-- Start Content-->
        <div class="container-fluid">
            
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box">
                        <h4 class="page-title">Pembelian</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-lg-8">
                                   
                                </div>
                                <div class="col-lg-4">
                                    <div class="text-lg-end">
                                        <a href="data-pembelian" class="btn btn-light waves-effect mb-2">Buat Pesanan Barang Baru</a>
                                        <a href="data-pembelian-restock" class="btn btn-light waves-effect mb-2">Buat Pesanan (Restock)</a>
                                    </div>
                                </div><!-- end col-->
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0" id="basic-datatables">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Order ID</th>
                                            <th>Pengaju Pembelian</th>
                                            <th>Tanggal</th>
                                            <th>Status Pengajuan</th>
                                            <th>Total</th>
                                            <th>Total Diskon</th>
                                            <th>Status Pembelian</th>
                                            <th style="width: 125px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div> <!-- end col -->
            </div>
            <!-- end row -->
            
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

    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Detail Pembelian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card-body">
                                <input type="hidden" name="id" id="id_hidden">
                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Data Pembelian</h5>

                                <div class="mb-3">
                                    <label for="product-meta-title" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control" name="nomor_surat" id="nomor-surat-pesan"
                                        value="" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="product-meta-title" class="form-label">Pengaju</label>
                                    <input type="text" class="form-control" name="pengaju" id="pengaju"
                                        value="" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Supplier</label>
                                    <input type="text" class="form-control" name="supplier" id="supplier" readonly required>
                                </div>
                                <div>
                                    <label for="product-meta-description" class="form-label">Tanggal</label>
                                    <input type="date" class="form-control" id="tgl_pesan" name="tgl_pesan" required readonly/>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <table class="table table-centered table-nowrap mb-0" id="detail-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th>Nama / Kode Barang</th>
                                        <th>Detail</th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>Harga</th>
                                        <th>Diskon</th>
                                        <th>Ppn</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                        <div class="text-end mt-3">
                            <a href="javascript:void(0);" class="btn btn-success btn-acc" style="float: right; margin-left:10px">Setujui</a>
                            <a href="javascript:void(0);" class="btn btn-danger btn-tolak" style="float: right; margin-left:10px">Tolak</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
@if(Session::has('alert-success'))
    <script>
            Swal.fire({
                title: 'Sukses!',
                text: '{{Session::get('alert-success')}}',
                icon: 'success',
                button: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn btn-primary"
            }
        })
    </script>
    @elseif(Session::has('alert-fail'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '{{Session::get('alert-fail')}}',
            icon: 'error',
            button: {
            text: "Ok",
            value: true,
            visible: true,
            className: "btn btn-danger"
        }
    })
</script>
@endif
    <script>

        $('#default-datatable').DataTable();
        $.fn.dataTable.render.moment = function(from, to, locale) {
            // Argument shifting
            if (arguments.length === 1) {
                locale = 'en';
                to = from;
                from = 'YYYY-MM-DD';
            } else if (arguments.length === 2) {
                locale = 'en';
            }

            return function(d, type, row) {
                if (!d) {
                    return type === 'sort' || type === 'type' ? 0 : d;
                }

                var m = window.moment(d, from, locale, true);

                // Order and type get a number value from Moment, everything else
                // sees the rendered value
                return m.format(type === 'sort' || type === 'type' ? 'x' : to);
            };
        };

    var table = $('#basic-datatables').DataTable({
        lengthChange: false,
        //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
        buttons: [],
        ajax: {
            url: '/data-pembelians',
            method: "GET",
            dataSrc: "",
            data: {
                _token: "{{ csrf_token() }}",
            }
        },
        columns: [{
                data: "id_order"
            },
            {
                data: "nama_staf"
            },
            {
                data: "tgl_order",
                render: $.fn.dataTable.render.moment('D MMMM YYYY')
            },
            {
                data: "stat_pengajuan"
            },
            {
                data: "total",
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp' )
            },
            {
                data: "diskon_order",
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp' )
            },
            {
                data: "stat_pembelian"
            },
            {
                data: "action"
            }
        ],
        initComplete: function () {
            table.buttons().container()
                .appendTo('#example_wrapper .col-md-6:eq(0)');
        }
    }); 

    $('#basic-datatables tbody').on('click', '.btn-detail', function() {
            var id = $(this).data("id");
            $('#id_hidden').val(id);
            $.ajax({
                url: '/detail-order-po',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id,
                    retur:0
                }),
                success: function(e) {
                    $('#nomor-surat-pesan').val(e.order[0].id_order);
                    $('#pengaju').val(e.order[0].nama_staf);
                    $('#supplier').val(e.order[0].nama_supplier);
                    $('#tgl_pesan').val(e.order[0].tgl_order);

                    if(e.order[0].status==1||e.order[0].status==2){
                        $('.btn-acc').hide();
                        $('.btn-tolak').hide();
                    }else{
                        $('.btn-acc').show();
                        $('.btn-tolak').show();
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                            title: "Gagal",
                            text: "Cek Kembali Data Anda !",
                            icon: "error"
                        });
            });

            $('#detail-datatables').DataTable().destroy();
            var table = $('#detail-datatables').DataTable({
                lengthChange: false,
                //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
                buttons: [],
                ajax: {
                    url: '/detail-pembelians',
                    method: "POST",
                    dataSrc: "",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    }
                },
                columns: [{
                        data: "kode_barang"
                    },
                    {
                        data: "nama_barang"
                    },
                    {
                        data: "jumlah"
                    },
                    {
                        data: "satuan"
                    },
                    {
                        data: "harga_beli",
                        render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')
                    },
                    {
                        data: "diskon"
                    },
                    {
                        data: "ppn"
                    },
                    {
                        data: "total",
                        render: $.fn.dataTable.render.number(',', '.', 2, 'Rp')
                    }
                ],
                initComplete: function () {
                    table.buttons().container()
                        .appendTo('#example_wrapper .col-md-6:eq(0)');
                }
            });
        });

        $('body').on('click', '.btn-acc', function() {
            swal.fire({
                    title: "Setujui Pengajuan Pembelian?",
                    text: "Data Pengajuan dapat diunduh setelah disetujui",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Setujui!",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    e.value ?
                        $.ajax({
                            type: "POST",
                            url: '/acc-pembelian',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: $('#id_hidden').val(),
                                status:1
                            }
                        }).done(function(msg) {
                            datob = JSON.parse(msg);
                            $('#basic-datatables').DataTable().ajax.reload();
                            if (datob != 'error') {
                                Swal.fire({
                                    title: "Sukses",
                                    text: "Dokumen Anda Telah Disetujui!",
                                    icon: "success"
                                });
                                $('#custom-modal').modal('toggle');
                            } else {
                                swal.fire("Data Anda Batal Disetujui!", {
                                    icon: "error",
                                });
                            }
                        })

                        :
                        swal.fire("Data anda aman !");

                });

        });

        $('body').on('click', '.btn-tolak', function() {
            swal.fire({
                    title: "Tolak Pengajuan Pembelian?",
                    text: "Data Pengajuan tidak dapat diunduh setelah ditolak",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Tolak!",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    e.value ?
                        $.ajax({
                            type: "POST",
                            url: '/acc-pembelian',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: $('#id_hidden').val(),
                                status:2
                            }
                        }).done(function(msg) {
                            datob = JSON.parse(msg);
                            $('#basic-datatables').DataTable().ajax.reload();
                            if (datob != 'error') {
                                Swal.fire({
                                    title: "Sukses",
                                    text: "Anda Telah Menolak Pengajuan!",
                                    icon: "success"
                                });
                                $('#custom-modal').modal('toggle');
                            } else {
                                swal.fire("Data Anda Batal Ditolak!", {
                                    icon: "error",
                                });
                            }
                        })

                        :
                        swal.fire("Data anda aman !");

                });

        });
    
    </script>
   @endsection