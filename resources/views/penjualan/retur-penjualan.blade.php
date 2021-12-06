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
                        <h4 class="page-title">Retur Penjualan</h4>
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
                                    {{-- <div class="text-lg-end">
                                        <a href="data-pembelian" class="btn btn-light waves-effect mb-2">Buat Pesanan Baru</a>
                                    </div> --}}
                                </div><!-- end col-->
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap mb-0" id="basic-datatables">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Transaction ID</th>
                                            <th>Total</th>
                                            <th>Tanggal Transaksi</th>
                                            <th>Kasir</th>
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

    

    <div class="modal fade" id="custom-modal-retur" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Tambah Retur Pembelian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="pilih-retur">
                                {{ csrf_field() }}
                            <table class="table table-centered table-nowrap mb-0" id="retur-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama </th>
                                        <th>Jumlah</th>
                                        <th>Satuan</th>
                                        <th>History Retur</th>
                                        <th>Jumlah Retur</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
                        </div>
                    </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="custom-modal-retur-item" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Retur Item Pembelian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <form id="pilih-retur-item">
                                {{ csrf_field() }}
                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Kode Barang</label>
                                    <input type="hidden" class="form-control" name="no_transaksi" id="no_transaksi" readonly required>
                                    <input type="text" class="form-control" name="kode_barang" id="kode_barang" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Nama Barang</label>
                                    <input type="text" class="form-control" name="nama_barang" id="nama_barang" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Jumlah Beli</label>
                                    <input type="text" class="form-control" name="jumlah" id="jumlah" readonly required>
                                </div>
                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Jumlah Retur</label>
                                    <input type="number" class="form-control" name="jml_retur" id="jml_retur" required>
                                </div>
                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Deskripsi</label>
                                    <textarea class="form-control" name="deskripsi" id="deskripsi" required></textarea>
                                </div>

                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">History Retur Pembelian</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row">
                        <div class="col-sm-12">
                            <table class="table table-centered table-nowrap mb-0" id="detail-retur-datatables">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID Retur</th>
                                        <th>Tanggal Retur</th>
                                        <th>Barang</th>
                                        <th>Deskripsi</th>
                                        <th>Jumlah Retur</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>


                                </tbody>
                            </table>
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
        order: [[ 3, "desc" ]],
        //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
        buttons: [],
        ajax: {
            url: '/data-transaksi',
            method: "GET",
            dataSrc: "",
            data: {
                _token: "{{ csrf_token() }}",
            }
        },
        columns: [{
                data: "no_transaksi"
            },
            {
                data: "total",
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp' )
            },
            {
                data: "tgl_transaksi"
            },
            {
                data: "nama_staf"
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

            $('#retur-datatables').DataTable().destroy();
            var table = $('#retur-datatables').DataTable({
                lengthChange: false,
                order: [[ 1, "desc" ]],
                //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
                buttons: [],
                ajax: {
                    url: '/list-produk',
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
                        data: "tgl_retur"
                    },
                    {
                        data: "jml_retur"
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
        });

        $('#retur-datatables tbody').on('click', '.btn-detail-item', function() {
            var id = $(this).data("id");

                $.ajax({
                    url: '/detail-order',
                    type: 'post',
                    dataType: 'json',
                    data: ({
                        _token: "{{ csrf_token() }}",
                        id: id,
                        retur: 1
                    }),
                    success: function (e) {
                        $('#no_transaksi').val(e[0].no_transaksi);
                        $('#kode_barang').val(e[0].kode_barang);
                        $('#jumlah').val(e[0].jumlah);
                        $('#nama_barang').val(e[0].nama_barang);
                        $("#jml_retur").attr({
                            "max": e[0].jumlah
                        });
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        title: "Gagal",
                        text: "Cek Kembali Data Anda !",
                        icon: "error"
                    });
                });
        });

        $("#pilih-retur-item").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#pilih-retur-item')[0]);
            $.ajax({
                url: '{{ url("retur-barang-penjualan") }}',
                type: 'post',
                data: formData,
                contentType: false, //untuk upload image
                processData: false, //untuk upload image
                timeout: 300000, // sets timeout to 3 seconds
                dataType: 'json',
                success: function(e) {
                    Swal.fire({
                            title: "Sukses",
                            text: "Retur Berhasil Diinput!",
                            icon: "success"
                        });
                      $('#basic-datatables').DataTable().ajax.reload();
                        $('#custom-modal-retur-item').modal('toggle');
                        $('#pilih-retur-item')[0].reset();     
                }

            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                            title: "Gagal",
                            text: "Pilih Item Terlebih Dahulu",
                            icon: "error"
                        });
            });
        });

        $('#basic-datatables tbody').on('click', '.btn-retur', function() {
            var id = $(this).data("id");

            $.ajax({
                url: '/detail-order',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id,
                    retur:1
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

            $.ajax({
                url: '/detail-retur',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id,
                    retur:1
                }),
                success: function(e) {
                    $("#retur-datatables tbody tr").remove();
                    $.each(e, function(key, value) {
                        $('#retur-datatables tbody').append(
                            `<tr>
                                <td><input type="hidden" class="id_list_order" name="id_list_order[]" value="${value.id_list_order}"><div class="form-check">
                                                    <input type="checkbox" class="form-check-input check-retur" id="customCheck11" name="check_retur[]">
                                                    <label class="form-check-label" for="customCheck11">&nbsp;</label>
                                                </div></td>
                                <td>${value.kode_barang}</td>
                                <td>${value.jumlah}</td>
                                <td>${value.satuan}</td>
                                <td>${value.jumlah_diterima}</td>
                                <td>${value.tgl_exp}</td>
                                <td><input type="number" class="form-control" name="jml_retur[]" value="${value.jumlah-value.jumlah_diterima}" placeholder="Jumlah"> </td>
                                <td><input type="text" class="form-control" name="deskripsi_retur[]"> </td>
                                </tr>`);
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                            title: "Gagal",
                            text: "Cek Kembali Data Anda !",
                            icon: "error"
                        });
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
                                swal.fire("Dokumen Anda Telah Disetujui!", {
                                    icon: "success",
                                });
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
                                swal.fire("Anda Telah Menolak Pengajuan!", {
                                    icon: "success",
                                });
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