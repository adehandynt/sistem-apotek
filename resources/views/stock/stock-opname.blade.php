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
                            <h4 class="page-title">Stock Opname</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <button type="button" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#custom-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Stock Opname</button>
                                                <button type="button" id="sinkronasi_stok" class="btn btn-info waves-effect waves-light"><i
                                                    class="mdi mdi-refresh"></i> Sinkronasi Stock</button>
                                                {{-- <button type="button" class="btn btn-danger waves-effect waves-light" id="stock-opname"><i
                                                    class="mdi mdi-plus-circle me-1"></i> Stock Opname</button> --}}
                                    </div>
                                    <div class="col-lg-6 float-right">
                                        <div class="card ribbon-box">
                                            <div class="card-body">
                                                <div class="ribbon ribbon-success float-end"><i class="mdi mdi-access-point me-1"></i> Update</div>
                                                <h5 class="text-success float-start mt-0">Update Fitur</h5>
                                                <div class="ribbon-content">
                                                    <p class="mb-0">Fitur<b> Sinkronasi Stock</b>,<br>digunakan untuk menyesuaikan/update stock barang yang tersedia sesuai dengan.<br>
                                                        jumlah fisik yang diinputkan pada stock opname.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th>ID Opname</th>
                                                <th>Tanggal Opname</th>
                                                <th>PIC</th>
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
                        <h4 class="modal-title" id="myCenterModalLabel">Stock Opname</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        
                        <div class="col-lg-6 float-right">
                            <div class="card ribbon-box">
                                <div class="card-body">
                                    <div class="ribbon ribbon-warning float-end"><i class="mdi mdi-access-point me-1"></i> Perhatian</div>
                                    <h5 class="text-warning float-start mt-0">Instruksi</h5>
                                    <div class="ribbon-content">
                                        <p class="mb-0">Isi Pada kolom berwarna kuning,<br><b>Klik Simpan apabila setiap satu halaman telah selesai di input</b>.<br>
                                            Setiap barang yang telah diinput dan disimpan akan hilang dari daftar barang pada tabel dibawah ini.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                        <form id="form-opname">
                            {{ csrf_field() }}
                            <div class="table-responsive mt-4">
                            <table class="table table-centered table-nowrap table-striped" id="order-datatables">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        <th>Saldo Awal</th>
                                        <th>Tercatat (Sistem)</th>
                                        <th>Jumlah Fisik</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Hilang</th>
                                        <th>Rusak</th>
                                        <th>Selisih</th>
                                        <th>Saldo Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($list_produk as $item)
                                        <tr>
                                            <td><input type="hidden" class="kode_barang form-control" name="kode_barang[]" value="{{$item->kode_barang}}" readonly/>{{$item->kode_barang}}</td>
                                            <td>{{$item->nama_barang}}</td>
                                            <td><input type="number" class="saldo_awal numeric_form form-control" name="saldo_awal[]" style="width:150px" value="{{$item->saldo_awal}}" readonly/></td>
                                            <td><input type="number" class="jml_tercatat numeric_form form-control" name="jml_tercatat[]" style="width:150px" value="{{$item->sisa_tercatat}}" readonly/></td>
                                            <td><input type="number" class="jml_tersedia numeric_form form-control" name="jml_tersedia[]" style="width:150px;background:rgb(218, 218, 112)" value="{{$item->sisa_tercatat}}" required/></td>
                                            <td><input type="number" class="masuk numeric_form form-control" name="masuk[]" style="width:150px" value="{{$item->totalMasuk}}" required readonly/></td>
                                            <td><input type="number" class="keluar numeric_form form-control" name="keluar[]" style="width:150px" value="{{$item->totalKeluar}}" required readonly/></td>
                                            <td><input type="number" class="hilang numeric_form form-control" name="hilang[]" style="width:150px;background:rgb(218, 218, 112)" value="0" required/></td>
                                            <td><input type="number" class="rusak numeric_form form-control" name="rusak[]" style="width:150px;background:rgb(218, 218, 112)" value="0" required/></td>
                                            <td><input type="number" class="selisih form-control" name="selisih[]" value="0" style="width:150px" readonly /></td>
                                            {{-- <td><input type="number" class="saldo_akhir form-control" name="saldo_akhir[]" value="{{$item->saldo_awal+$item->totalMasuk-$item->totalKeluar}}" style="width:150px" readonly /></td> --}}
                                            <td><input type="number" class="saldo_akhir form-control" name="saldo_akhir[]" value="{{$item->sisa_tercatat}}" style="width:150px" readonly /></td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    
                            <div class="text-end">
                                <button type="submit" class="btn btn-success waves-effect waves-light mt-2" id="simpan_laporan_stok" >Simpan Opname Halaman <span id="page_number">1</span></button>
                                {{-- <button type="button" class="btn btn-danger waves-effect waves-light"
                                    data-bs-dismiss="modal">Batal</button> --}}
                            </div>
                        </form>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="detail-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-xl">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="titleDetailOpname">Stock Opname Detail</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <div class="table-responsive mt-4">
                        <form id="form-opname-detail">
                            {{ csrf_field() }}
                            <table class="table table-centered table-nowrap table-striped" id="detail-datatables">
                                <thead>
                                    <tr>
                                        <th>Kode Barang</th>
                                        <th>Nama Barang</th>
                                        {{-- <th>Saldo Awal</th> --}}
                                        <th>Tercatat (Sistem)</th>
                                        <th>Jumlah Fisik</th>
                                        <th>Masuk</th>
                                        <th>Keluar</th>
                                        <th>Hilang</th>
                                        <th>Rusak</th>
                                        <th>Selisih</th>
                                        <th>Saldo Akhir</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                </tbody>
                            </table>
                        </form>
                    </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


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
                $('#form-opname')[0].reset();
        });
        $('#order-datatables').DataTable({
            // lengthChange: true,
             lengthMenu:[[10],["10"]],"searching": false,"ordering": false,"order": [[ 1, "asc" ]]
            });

            var tableList = $('#order-datatables').DataTable();
            var info = tableList.page.info();
       
            $('#order-datatables').on('page.dt', function () {
                var info = tableList.page.info();
                $('#page_number').text(info.page+1);
                // $('#simpan_laporan_stok').click();
                // swal.fire("Data Stock Pada Halaman Sebelumnya telah disimpan");
                // swal.fire({
                //     title: "Simpan Data Stok Halaman "+(info.page) +"?",
                //     text: "Simpan data untuk melanjutkan pada halaman selanjutnya",
                //     icon: "warning",
                //     showCancelButton: !0,
                //     confirmButtonColor: "#28bb4b",
                //     cancelButtonColor: "#f34e4e",
                //     confirmButtonText: "Ya",
                //     cancelButtonText: "Batal"
                // })
                // .then(function(e) {
                //     e.value ?
                //         $('#simpan_laporan_stok').click()

                //         :
                //         swal.fire("Data anda aman !");

                // });
            });

            $('#stock-opname').click(function(){
                swal.fire("Fitur Masih Dalam Tahap Pengembangan (Progress 90%) !");
            })

            $('#buat_laporan_stock').click(function () {
                var formData = new FormData();
                var data = $('#order-datatables').DataTable().$('input, select').serialize();
                formData.append('list', data);
                $.ajax({
                    url: '{{ url('add-opname')}}',
                    type: 'post',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: formData,
                    contentType: false, //untuk upload image
                    processData: false, //untuk upload image
                    timeout: 300000, // sets timeout to 3 seconds
                    dataType: 'json',
                    success: function (e) {
                        if (e) {
                            Swal.fire({
                                title: "Sukses",
                                text: "Data Berhasil Diinput!",
                                icon: "success"
                            });
                            setTimeout(location.reload(), 2000);
                        } else {
                            var text = "";
                            $.each(e.customMessages, function (key, value) {
                                text += `<br>` + value;
                            });
                            Swal.fire({
                                title: "Gagal",
                                text: text,
                                icon: "error"
                            });
                        }
                    }
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    errorAlertServer('Response Not Found, Please Check Your Data');
                });
                return false;
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
                url: '/data-stock-opname',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: "id_opname"
                },
                {
                    data: "tgl_opname",
                    render: $.fn.dataTable.render.moment('D MMMM YYYY')
                },
                {
                    data: "pic"
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
       
        $("#form-opname").submit(function (event) {
            event.preventDefault();
            swal.fire({
                    title: "Input Stok Opname Barang ",
                    text: "Pastikan bahwa data telah diisi semua,\n Lanjutkan Proses ? ",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Lanjutkan",
                    cancelButtonText: "Batal, Periksa Kembali"
                })
                .then(function (e) {
                    if (e.value) {
                        var formData = new FormData($('#form-opname')[0]);
                        $.ajax({
                            url: '{{ url('add-opname')}}',
                            type: 'post',
                            data: formData,
                            contentType: false, //untuk upload image
                            processData: false, //untuk upload image
                            timeout: 300000, // sets timeout to 3 seconds
                            dataType: 'json',
                            success: function (e) {
                                if (e) {
                                    Swal.fire({
                                        title: "Sukses",
                                        text: "Data Berhasil Diinput!",
                                        icon: "success"
                                    });
                                    setTimeout(location.reload(), 2000);
                                } else {
                                    var text = "";
                                    $.each(e.customMessages, function (key, value) {
                                        text += `<br>` + value;
                                    });
                                    Swal.fire({
                                        title: "Gagal",
                                        text: text,
                                        icon: "error"
                                    });
                                }
                            }
                        }).fail(function (jqXHR, textStatus, errorThrown) {
                            errorAlertServer('Response Not Found, Please Check Your Data');
                        });

                    } else {
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
                errorAlertServer('Response Not Found, Please Check Your Data');
            });
        });

        $('#basic-datatables tbody').on('click', '.btn-detail', function() {
            var id = $(this).data("id");
            $.ajax({
                url: '{{ url('detail-stock-opname') }}',
                type: 'get',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    $('#id_hide').val(id);
                    $("#detail-datatables tbody tr").remove();
                    $("#titleDetailOpname").text('Stock Opname Detail');
                    let judul = $("#titleDetailOpname").text();
                    $("#titleDetailOpname").text(judul+' ('+new Date(e[0].tgl_opname).toLocaleDateString('id-ID',{ year: 'numeric', month: 'long', day: '2-digit' })+') ');
                 
                    $.each(e, function(key, value) {
                        $('#detail-datatables tbody').append(`<tr>
                                            <td><input type="hidden" class="kode_barang form-control" name="kode_barang[]" value="${value.kode_barang}" readonly/>${value.kode_barang}</td>
                                            <td>${value.nama_barang}</td>
                                            <td><input type="number" class="jml_tercatat numeric_form form-control" name="jml_tercatat[]" style="width:150px" value="${value.jml_tercatat}" readonly/></td>
                                            <td><input type="number" class="jml_tersedia numeric_form form-control" name="jml_tersedia[]" style="width:150px"value="${value.jml_fisik}" readonly/></td>
                                            <td><input type="number" class="masuk numeric_form form-control" name="masuk[]" style="width:150px" value="${value.masuk}" required readonly/></td>
                                            <td><input type="number" class="keluar numeric_form form-control" name="keluar[]" style="width:150px" value="${value.keluar}" required readonly/></td>
                                            <td><input type="number" class="hilang numeric_form form-control" name="hilang[]" style="width:150px" value="${value.hilang}" readonly/></td>
                                            <td><input type="number" class="rusak numeric_form form-control" name="rusak[]" style="width:150px" value="${value.rusak}" readonly/></td>
                                            <td><input type="number" class="selisih numeric_form form-control" name="rusak[]" style="width:150px" value="${value.selisih}" readonly/></td>
                                            <td><input type="number" class="saldo_akhir form-control" name="saldo_akhir[]" value="${value.saldo_akhir}" style="width:150px" readonly /></td>
                                            
                                        </tr>`);
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                errorAlertServer('Response Not Found, Please Check Your Data');
            });
        });

        $('#btn-modal').click(function(e) {
            $('#form-opname')[0].reset();
        });

        
        $('#order-datatables tbody').on('change', '.jml_tersedia, .hilang, .rusak', function() {
            let idx = $('.jml_tersedia').index(this);
            let jml_tercatat=parseInt($('.jml_tercatat').eq(idx).val());
            let jml_tersedia= parseInt($('.jml_tersedia').eq(idx).val());
            let hilang= parseInt($('.hilang').eq(idx).val());
            let rusak= parseInt($('.rusak').eq(idx).val());
            $('.selisih').eq(idx).val((jml_tersedia)-jml_tercatat);
            $('.saldo_akhir').eq(idx).val(jml_tersedia);

        });

        $('#order_id').change(function(e) {
            $("#scan").focus();
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

            $("#order-datatables tbody tr").remove();
            $.ajax({
                url: '/order-list',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: $(this).val()
                }),
                success: function(e) {

                    $.each(e, function(key, value) {
                        $('#order-datatables tbody').append(
                            `<tr class="br${value.kode_barang}">
                            <td>${value.kode_barang}</td>
                            <td>${value.nama_barang}</td>
                            <td>${value.jumlah}</td>
                            <td><input type="text" class="form-control" name="jml_diterima[]" value="" required/>
                            <input type="hidden" class="form-control" name="id_list_order[]" value="${value.id_list_order}" required/></td>
                            <td><input type="date" class="form-control" name="exp[]" value="" required/></td>
                            <td><select class="form-control" id="status_receive" name="status_receive[]" style="width:150px" required>
                                    <option value='1'>Full</option>
                                    <option value='0'>Pending</option>
                                </select></td>
                                <td><input type="text" class="form-control" name="deskripsi[]" value="" style="width:200px" required/></td>
                        </tr>`
                        );
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                swal.fire("Gagal Periksa Kembali Data Anda !", {
                    icon: "error",
                });
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
                        $("#order-datatables tbody tr").hide();
                        $.each(e, function(key, value) {
                            classes='br'+value.kode_barang;
                            $("."+classes).show();
                        
                    });
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
                    e.value ?
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
                        $('#add-modal').modal('show')
                        :
                        swal.fire("Input Dibatalkan !");

                });
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                swal.fire("Gagal, Cek Kembali Data Anda !");
            });
        }

        $('#sinkronasi_stok').click(function () {

            swal.fire({
                title: "Sinkronasi Data",
                text: "Data yang telah disinkronasi tidak dapat dikembalikan !. Lakukan Sinkronasi Setelah Proses Opname Selesai",
                icon: "warning",
                showCancelButton: !0,
                confirmButtonColor: "#28bb4b",
                cancelButtonColor: "#f34e4e",
                confirmButtonText: "Ya",
                cancelButtonText: "Batal"
            }).then(function (e) {
                if (e.value) {
                    $.ajax({
                        url: '{{ url('set-as-stock') }}',
                        type: 'get',
                        dataType: 'json',
                        data: "",
                        success: function (e) {
                            Swal.fire({
                            title: "Sukses",
                            text: "Stock Berhasil Disinkronasi!",
                            icon: "success"
                        });
                        }
                    }).fail(function (jqXHR, textStatus, errorThrown) {
                        swal.fire("Gagal, Cek Kembali Data Anda !");
                    });
                } else {
                    swal.fire("Sinkronasi Dibatalkan !");
                }

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


        $('#harga_beli, #margin').on('input', function() {
            let harga = $('#harga_beli').val();
            $('#harga_jual').val(((parseInt(harga)) + parseInt(harga * ($('#margin').val()/100))));
        });

    </script>
@endsection
