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
                        <h4 class="page-title">Laporan Barang Konsinyasi</h4>
                    </div>
                </div>
            </div>     
            <!-- end page title --> 


            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row mb-2">
                                <div class="col-sm-4">
                                    <button type="button" id="btn-modal" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-printer-check"></i> Parameter Print Konsinyasi</button>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Konsinyasi</th>
                                            <th>Terjual</th>
                                            <th>Sisa</th>
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Parameter Cetak Laporan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-print" action="{{ url("print-konsinyasi-params") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Barang</label>
                            <select class="form-control" id="nama_barang" name="nama_barang" data-toggle="select2" data-width="100%">
                                <option value="">-Pilih-</option>
                                @foreach ($barang as $item)
                                <option value={{$item->kode_barang}}>{{$item->kode_barang}} - {{$item->nama_barang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Bulan</label>
                            <select class="form-control" id="bulan" name="bulan" data-width="100%">
                                <option value="">-Pilih-</option>
                                <option value="01">Januari</option>
                                <option value="02">Februari</option>
                                <option value="03">Maret</option>
                                <option value="04">April</option>
                                <option value="05">Mei</option>
                                <option value="06">Juni</option>
                                <option value="07">Juli</option>
                                <option value="08">Agustus</option>
                                <option value="09">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tahun</label>
                            <select class="form-control" id="tahun" name="tahun" data-toggle="select2" data-width="100%">
                                <option value="">-Pilih-</option>
                                @php
                                     $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
                                    @endphp
                                @endphp
                                @for ($i=$year;$i>=2020;$i--)
                                <option value={{$i}}>{{$i}}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Print</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script>
        
        $('#nama_barang').select2({
        dropdownParent: $('#custom-modal')
    });
    
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
                url: '/list-laporan',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                    type:'konsinyasi'
                }
            },
            columns: [{
                    data: "no"
                },
                {
                    data: "nama_barang"
                },
                {
                    data: "konsinyasi"
                },
                {
                    data: "terjual"
                },
                {
                    data: "sisa"
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
        $("#form-print").submit(function(event) {
            // event.preventDefault();
            // var formData = new FormData($('#form-print')[0]);
            // $.ajax({
            //     url: '{{ url("print-narkotika-params") }}',
            //     type: 'post',
            //     data: formData,
            //     contentType: false, //untuk upload image
            //     processData: false, //untuk upload image
            //     timeout: 5000000, // sets timeout to 3 seconds
            //     dataType: 'json',
            //     success: function(e) {
            //         if (e) {
            //             Swal.fire({
            //                 title: "Sukses",
            //                 text: "Data Berhasil Diinput!",
            //                 icon: "success"
            //             });
            //             $('#basic-datatables').DataTable().ajax.reload();
            //             $('#custom-modal').modal('toggle');
            //             $('#form-print')[0].reset();
            //         } else {
            //             var text = "";
            //             $.each(e.customMessages, function(key, value) {
            //                 text += `<br>` + value;
            //             });
            //             Swal.fire({
            //                 title: "Gagal",
            //                 text: text,
            //                 icon: "error"
            //             });
            //         }
            //     }
            // }).fail(function(jqXHR, textStatus, errorThrown) {
            //     Swal.fire({
            //                 title: "Data TIdak Tersedia",
            //                 text: "Cek Kembali Data Anda !",
            //                 icon: "error"
            //             });
            // });
        });

        $("#form-print-edit").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-print-edit')[0]);
            $.ajax({
                url: '{{ url("update-tindakan") }}',
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
                        $('#basic-datatables').DataTable().ajax.reload();
                        $('#custom-modal-edit').modal('toggle');
                        $('#form-print-edit')[0].reset();
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
                errorAlertServer('Response Not Found, Please Check Your Data');
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
                            url: '/delete-tindakan',
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

        $('#basic-datatables tbody').on('click', '.btn-edit', function() {
            var id = $(this).data("id");
            $.ajax({
                url: '{{ url("edit-tindakan") }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    $('#id').val(id);
                    $.each(e, function(key, value) {
                        $('#' + key+"_edit").val(value);
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                errorAlertServer('Response Not Found, Please Check Your Data');
            });
        });

        $('#btn-modal').click(function(e) {
            $('#form-print')[0].reset();
        });
    </script>
@endsection
