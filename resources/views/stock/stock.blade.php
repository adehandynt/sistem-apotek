@extends('main/app')
@section('content')
<style>
    .modal-content{
        box-shadow:30px 30px 7px rgba(0, 0, 0, 0.3);
    }
</style>
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Stock</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12 text-sm-end">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#custom-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Tambah Stock</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Tanggal Masuk</th>
                                                <th>Tanggal Expired</th>
                                                {{-- <th>Akumulasi Jumlah</th>
                                                <th>Sisa Barang</th> --}}
                                                <th style="width: 85px;">Action</th>
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
        <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Pilih Dokumen Order</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="form-order">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="id_hide" name="id_hide">
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">No. Dokumen PO</label>
                                <select class="form-control" id="order_id" name="order_id" required>
                                    <option value='0'>-- Pilih Nomor Dokumen --</option>
                                    @foreach ($data as $item)
                                        <option value="{{ $item->id_order }}">{{ $item->id_order }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">GRN</label>
                                <input type="text" class="form-control" id="grn" name="grn" readonly required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">NO FAKTUR</label>
                                <input type="text" class="form-control" id="faktur" name="faktur" required>
                            </div>  
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">SUPPLIER D.O</label>
                                <input type="text" class="form-control" id="do" name="do" required>
                            </div> 
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">SCAN PRODUCT (arahkan cursor)</label>
                                
                                <input type="text" class="form-control" id="scan" name="scan" onmouseover="this.focus();">
                                <input type="hidden" class="form-control" id="scanHidden" name="scanHidden" required>
                            </div> 
                            <div class="table-responsive mb-4">
                                <table class="table table-centered table-nowrap table-striped" id="order-datatables">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Order</th>
                                            <th>Jumlah Diterima</th>
                                            <th>Tanggal Expired</th>
                                            <th>Status</th>
                                            <th>Deskripsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Masukan
                                    Barang</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Detail Stock</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="form-order">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="id_hide" name="id_hide">
                            <div class="table-responsive mb-4">
                                <table cellspacing="5" cellpadding="5" border="0">
                                    <tbody><tr>
                                        <td>Set Tanggal:</td>
                                        <td><input type="date" id="set_date" name="set_date"></td>
                                    </tr>
                                </tbody></table>
                            <hr>
                                <table class="table table-centered table-nowrap table-striped" id="detail-datatables">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Jumlah Masuk</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Jumlah Keluar</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Sisa</th>
                                            <th>PIC</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                    </tbody>
                                </table>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <div class="modal fade" id="add-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Add Barang</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="table-responsive mb-4">
                            <table class="table table-centered table-nowrap table-striped" id="list-order-datatables">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Jumlah Order</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <hr>
                        <hr>
                        <form class="needs-validation" id="form-barang" novalidate style="display:none">
                            {{ csrf_field() }}
                            <input type="hidden" class="form-control" id="id_list_order" name="id_list_order" required>
                            <div class="mb-3">
                                <label for="name" class="form-label">Kode Barang</label>
                                <input type="text" class="form-control" id="kode_barang" name="kode_barang"
                                    placeholder="Kode Barang" autofocus required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
                                <input type="text" class="form-control" id="nama_barang" name="nama_barang"
                                    placeholder="Nama Barang" required>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label">Produsen</label>
                                <input type="text" class="form-control" id="produsen" name="produsen"
                                    placeholder="Produsen" required>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Tipe</label>
                                <select class="form-control" id="tipe_barang" name="tipe_barang"
                                    placeholder="Tipe Barang" required>
                                    @foreach ($tipe as $item)
                                        <option value="{{ $item->kode_tipe }}">{{ $item->nama_tipe }}</option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Kategori</label>
                                <select class="form-control" id="kategori" name="kategori"
                                    placeholder="Tipe Barang" required>
                                        <option value="generik">Generik</option>
                                        <option value="paten">Paten</option>
                                </select>
                            </div> --}}
                            <div class="mb-3">
                                <label for="position" class="form-label">Satuan Jual</label>
                                <select class="form-control" id="satuan" name="satuan" placeholder="Satuan Barang"
                                    required>
                                    @foreach ($satuan as $item)
                                        <option value="{{ $item->kode_satuan }}">{{ $item->satuan }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label">Jumlah Barang (per satuan)</label>
                                <input type="number" class="form-control" id="jml_per_satuan"
                                    name="jml_per_satuan" placeholder="Jumlah barang per satuan" required>
                            </div>
                            <div class="mb-3">
                                <input class="form-check-input" type="checkbox" value="1" id="status_ecer" name="status_ecer">
                                <label class="form-check-label" for="flexCheckDefault">
                                    Set Pembelian Eceran
                                </label>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label">Harga Beli</label>
                                <input type="number" class="form-control" min="0" value="0" id="harga_beli"
                                    name="harga_beli" placeholder="Harga Beli" required>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label">Margin ( % )</label>
                                <select class="form-control" id="margin" name="margin" placeholder="margin Barang"
                                required>
                                @foreach ($margin as $item)
                                    <option value="{{ $item->margin_percentage }}" selected>{{ $item->margin_name.' ( '.$item->margin_percentage.'% )' }}</option>
                                @endforeach
                            </select>
                            </div>
                            <div class="mb-3">
                                <label for="company" class="form-label">Harga Jual</label>
                                <input type="number" class="form-control" id="harga_jual" name="harga_jual"
                                    placeholder="Harga Jual" required readonly>
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Penyimpanan</label>
                                <input type="text" class="form-control" id="penyimpanan" name="penyimpanan"
                                    placeholder="Rak Penyimpanan" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Save</button>
                                <button type="reset" class="btn btn-danger waves-effect waves-light">Cancel</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>

        <!-- Footer Start -->
        <footer class="footer">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-6">
                        <script>
                            document.write(new Date().getFullYear())
                        </script> &copy; Apotek Sindangsari Farma
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
            $(document).ready(function() {
                $('#custom-modal').modal({backdrop: 'static', keyboard: false});
                $('#add-modal').modal({backdrop: 'static', keyboard: false});
                $('#order_id').prop('selectedIndex',0);
                $('#form-order')[0].reset();
        });
  
        $("#order_id select").val("0").change();
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
                url: '/data-stocks',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: "kode_barang"
                },
                {
                    data: "nama_barang"
                },
                {
                    data: "tgl_masuk",
                    render: $.fn.dataTable.render.moment('D MMMM YYYY')
                },
                {
                    data: "tgl_exp",
                    render: $.fn.dataTable.render.moment('D MMMM YYYY')
                },
                // {
                //     data: "jml_akumulasi"
                // },
                // {
                //     data: "sisa"
                // },
                {
                    data: "action"
                }
            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });
        $("#form-order").submit(function(event) {
            event.preventDefault();
            swal.fire({
                    title: "Input Penerimaan Barang ",
                    text: "Pastikan bahwa data barang telah diisi semua dan memiliki Barcode/Kode Barang,\n Lanjutkan Proses ? ",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Lanjutkan",
                    cancelButtonText: "Batal, Periksa Kembali"
                })
                .then(function(e) {
                    if(e.value){
                        var formData = new FormData($('#form-order')[0]);
                        $.ajax({
                            url: '{{ url('add-stock') }}',
                            type: 'post',
                            data: formData,
                            contentType: false, //untuk upload image
                            processData: false, //untuk upload image
                            timeout: 300000, // sets timeout to 3 seconds
                            dataType: 'json',
                            success: function(e) {
                                if (e) {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: "Data Berhasil Diinput!",
                                        icon: "success"
                                    });
                                    setTimeout(location.reload(), 2000);
                                } else {
                                    var text = "";
                                    $.each(e.customMessages, function(key, value) {
                                        text += `<br>` + value;
                                    });
                                    Swal.fire({
                                        title: "Gagal",
                                        text: text,
                                        icon: "error"
                                    });
                                }
                            }
                        }).fail(function(jqXHR, textStatus, errorThrown) {
                            Swal.fire({
                                        title: "Gagal",
                                        text: 'Reposn tidak diketahui, cek koneksi anda',
                                        icon: "error"
                                    });
                        });
                        
                    }else{
                        swal.fire("Input Dibatalkan, Silahkan Periksa Kembali Data Anda !");
                    }

                });
            
        });

        $('#basic-datatables tbody').on('click', '.btn-delete', function() {
            var id = $(this).data("id");
            swal.fire({
                    title: "Anda Yakin?",
                    text: "Data yang dihapus tidak dapat dikembalikan",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Hapus!",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    e.value ?
                        $.ajax({
                            type: "POST",
                            url: '/delete-supplier',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            }
                        }).done(function(msg) {
                            datob = JSON.parse(msg);
                            $('#basic-datatables').DataTable().ajax.reload();
                            if (datob != 'error') {
                                swal.fire("Your Data has been deleted!", {
                                    icon: "success",
                                });
                            } else {
                                swal.fire("Your Data has Failed to delete!", {
                                    icon: "error",
                                });
                            }
                        })

                        :
                        swal.fire("Data anda aman !");

                });

        });

        $('#basic-datatables tbody').on('click', '.btn-update', function() {
            var id = $(this).data("id");
            $.ajax({
                url: '{{ url('edit-supplier') }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    $('#id_hide').val(id);
                    $.each(e, function(key, value) {
                        $('#' + key).val(value);
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                            title: "Gagal",
                            text: 'Reposn tidak diketahui, cek koneksi anda',
                            icon: "error"
                        });
            });
        });

        $('#btn-modal').click(function(e) {
            $('#form-order')[0].reset();
        });

        $('#order_id').change(function(e) {
            $("#scan").focus();
            $('#order-datatables ').DataTable().destroy();
            $.ajax({
                url: '/get-grn',
                type: 'get',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}"
                }),
                success: function(e) {
                    $('#grn').val(e);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                swal.fire("Gagal Periksa Kembali Data Anda !", {
                    icon: "error",
                });
            });

            // $("#order-datatables tbody tr").remove();
            // $.ajax({
            //     url: '/order-list',
            //     type: 'post',
            //     dataType: 'json',
            //     data: ({
            //         _token: "{{ csrf_token() }}",
            //         id: $(this).val()
            //     }),
            //     success: function(e) {

            //         $.each(e, function(key, value) {
            //             $('#order-datatables tbody').append(
            //                 `<tr class="br${value.kode_barang}">
            //                 <td>${value.kode_barang}</td>
            //                 <td>${value.nama_barang}</td>
            //                 <td>${value.jumlah}</td>
            //                 <td><input type="number" class="form-control numeric_form" name="jml_diterima[]" value="" required/>
            //                 <input type="hidden" class="form-control" name="id_list_order[]" value="${value.id_list_order}" required/></td>
            //                 <td><input type="date" class="form-control" name="exp[]" value=""/></td>
            //                 <td><select class="form-control" id="status_receive" name="status_receive[]" style="width:150px" required>
            //                         <option value='1'>Full</option>
            //                         <option value='0'>Pending</option>
            //                     </select></td>
            //                     <td><input type="text" class="form-control" name="deskripsi[]" value="-" style="width:200px" required/></td>
            //             </tr>`
            //             );
            //         });
            //     }
            // }).fail(function(jqXHR, textStatus, errorThrown) {
            //     swal.fire("Gagal Periksa Kembali Data Anda !", {
            //         icon: "error",
            //     });
            // });

            var table = $('#order-datatables ').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/order-list',
                method: "POST",
                dataSrc: "",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).val()
                }
            },
            "autoWidth": false,
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
                    data: "jml_diterimas"
                },
                {
                    data: "exps"
                },
                {
                    data: "status_receives"
                },
                {
                    data: "deskripsis"
                }
            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });

            $('#list-order-datatables').DataTable().destroy();
            var table = $('#list-order-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/order-list',
                method: "POST",
                dataSrc: "",
                dataType: 'json',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: $(this).val()
                }
            },
            "autoWidth": false,
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
                    data: "action"
                }
            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });

        });

        $('#basic-datatables tbody').on('click', '.btn-detail', function() {
            var id = $(this).data("id");
            $('#id_hide').val(id);
            $('#detail-datatables').DataTable().destroy();
            var table = $('#detail-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/detail-list',
                method: "POST",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                    id:id,
                    date:""
                }
            },
            columns: [{
                    data: "kode_barang"
                },
                {
                    data: "nama_barang"
                },
                {
                    data: "jml_masuk"
                },
                {
                    data: "tgl_masuk"
                },
                {
                    data: "jml_keluar"
                },
                {
                    data: "tgl_keluar"
                },
                {
                    data: "sisa"
                },
                {
                    data: "pic"
                }
            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });
        });

        $('#set_date').change(function(e) {
            var id = $('#id_hide').val();
            var date = $('#set_date').val();
            $('#detail-datatables').DataTable().destroy();
            var table = $('#detail-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/detail-list',
                method: "POST",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                    id:id,
                    date:date
                }
            },
            columns: [{
                    data: "kode_barang"
                },
                {
                    data: "nama_barang"
                },
                {
                    data: "jml_masuk"
                },
                {
                    data: "tgl_masuk"
                },
                {
                    data: "jml_keluar"
                },
                {
                    data: "tgl_keluar"
                },
                {
                    data: "sisa"
                },
                {
                    data: "nip"
                }
            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });
        });

        var kode = "";
        var timer = null;
        $('#scan').on('input', function() {
            kode = $('#scan').val();
            $('#scanHidden').val(kode);
            if (kode != null) {
                clearTimeout(timer);
                timer = setTimeout(doStuff, 1000)
            } 
            $('#form-barang').hide();
        });

        function doStuff() {
            $.ajax({
                url: '{{ url('get-stock-produk') }}',
                type: 'get',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    kode: kode
                }),
                success: function(e) {
                    $('#scan').val("");
                    let component = '';

                    if (e.length > 0) {
                    //     $("#order-datatables tbody tr").hide();
                    //     $.each(e, function(key, value) {
                    //         classes='br'+value.kode_barang;
                    //         $("."+classes).show();
                        
                    // });
                    $('input[type="search"]').val(kode).keyup();
                    } else {
                        swal.fire({
                    title: "Data Belum Tersedia",
                    text: "Tambahkan Data Baru ?",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    if(e.value){

                        // $.ajax({
                        //     type: "POST",
                        //     url: '/acc-pembelian',
                        //     data: {
                        //         _token: "{{ csrf_token() }}",
                        //         id: $('#id_hidden').val(),
                        //         status:2
                        //     }
                        // }).done(function(msg) {
                        //     datob = JSON.parse(msg);
                        //     $('#basic-datatables').DataTable().ajax.reload();
                        //     if (datob != 'error') {
                        //         swal.fire("Anda Telah Menolak Pengajuan!", {
                        //             icon: "success",
                        //         });
                        //     } else {
                        //         swal.fire("Data Anda Batal Ditolak!", {
                        //             icon: "error",
                        //         });
                        //     }
                        // })
                        $('input[type="search"]').val('').keyup();
                        $('#add-modal').modal('show');
                    }else{
                        swal.fire("Input Dibatalkan !");
                    }

                });
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                swal.fire("Gagal, Cek Kembali Data Anda !");
            });
        }

        $('#list-order-datatables tbody').on('click', '.btn-choose', function() {
            $('#form-barang').show();
            $('#kode_barang').val($('#scanHidden').val());
            var id = $(this).data("id");
            $('#id_list_order').val(id);
                 $.ajax({
                     type: "POST",
                     url: '/detail-barang-pembelian',
                     dataType:'json',
                     data: {
                         _token: "{{ csrf_token() }}",
                         id: id
                     }
                 }).done(function (msg) {
                  
                     $('#harga_beli').val(msg.harga_beli);
                     $('#nama_barang').val(msg.kode_barang);
                     $('#harga_jual').val(msg.harga_beli+ (msg.harga_beli *($('#margin').val()/100)) );
                     $("#satuan select").val(msg.kode_satuan);

                 });
        });

        $("#form-barang").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-barang')[0]);
            $.ajax({
                url: '{{ url("add-barang?inbound=true") }}',
                type: 'post',
                data: formData,
                contentType: false, //untuk upload image
                processData: false, //untuk upload image
                timeout: 300000, // sets timeout to 3 seconds
                dataType: 'json',
                success: function(e) {
                    if (e) {
                        Swal.fire({
                            title: "Sukses",
                            text: "Data Berhasil Diinput!",
                            icon: "success"
                        });
                        $('#order-datatables').DataTable().ajax.reload();
                        $('#form-barang')[0].reset();
                        $('#add-modal').modal('hide');
                    } else {
                        var text = "";
                        $.each(e.customMessages, function(key, value) {
                            text += `<br>` + value;
                        });
                        Swal.fire({
                            title: "Gagal",
                            text: text,
                            icon: "error"
                        });
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                swal.fire("Gagal, Cek Kembali Data Anda !");
            });
        });


        $('#harga_beli, #margin').on('change', function() {
            let harga = $('#harga_beli').val();
            $('#harga_jual').val(((parseInt(harga)) + parseInt(harga * ($('#margin').val()/100))));
        });

    </script>
@endsection
