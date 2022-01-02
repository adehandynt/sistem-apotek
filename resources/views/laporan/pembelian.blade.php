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
                        <h4 class="page-title">Laporan Pembelian</h4>
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
                                    <button type="button" id="btn-modal" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-printer-check"></i> Parameter Print Pembelian</button>
                                    <button type="button" id="btn-modal" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal-2"><i class="mdi mdi-printer-check"></i> Parameter Excel Pembelian</button>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>ID Purchase Order</th>
                                            <th>Nama Supplier</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Total Pembelian</th>
                                            <th>Pengaju</th>
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
                    <form id="form-print" action="{{ url("print-pembelian") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Supplier</label>
                            <select class="form-control" id="supplier" name="supplier" data-toggle="select2" data-width="100%">
                                <option value="">-Pilih-</option>
                                @foreach ($supplier as $item)
                                <option value={{$item->id_supplier}}>{{$item->id_supplier}} - {{$item->nama_supplier}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tgl_awal" name="tgl_awal">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir">
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

    <div class="modal fade" id="custom-modal-2" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Parameter Cetak Laporan</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-print-excel" action="{{ url("export-excel-pembelian-params") }}" method="POST">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Supplier</label>
                            <select class="form-control" id="supplier" name="supplier" data-toggle="select2" data-width="100%">
                                <option value="">-Pilih-</option>
                                @foreach ($supplier as $item)
                                <option value={{$item->id_supplier}}>{{$item->id_supplier}} - {{$item->nama_supplier}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Awal</label>
                            <input type="date" class="form-control" id="tgl_awal" name="tgl_awal">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Akhir</label>
                            <input type="date" class="form-control" id="tgl_akhir" name="tgl_akhir">
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
    <script>
        
        $('#supplier').select2({
        dropdownParent: $('#custom-modal')
    });
    
        $('#default-datatable').DataTable();


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
                    type:'pembelian'
                }
            },
            columns: [{
                    data: "id_order"
                },
                {
                    data: "nama_supplier"
                },
                {
                    data: "tgl_order"
                },
                {
                    data: "total",
                render: $.fn.dataTable.render.number( ',', '.', 2, 'Rp ' )
                },
                {
                    data: "nama_staf"
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
        // $("#form-print").submit(function(event) {
        //     event.preventDefault();
        //     var formData = new FormData($('#form-print')[0]);
        //     $.ajax({
        //         url: '{{ url("print-pembelian") }}',
        //         type: 'post',
        //         data: formData,
        //         contentType: false, //untuk upload image
        //         processData: false, //untuk upload image
        //         timeout: 300000, // sets timeout to 3 seconds
        //         dataType: 'json',
        //         xhrFields:{
        //     responseType: 'blob'
        // },
        //         success: function(e) {
        //             if (e) {
        //                 Swal.fire({
        //                     title: "Sukses",
        //                     text: "Data Berhasil Diinput!",
        //                     icon: "success"
        //                 });
        //                 $('#basic-datatables').DataTable().ajax.reload();
        //                 $('#custom-modal').modal('toggle');
        //                 $('#form-print')[0].reset();
        //             } else {
        //                 var text = "";
        //                 $.each(e.customMessages, function(key, value) {
        //                     text += `<br>` + value;
        //                 });
        //                 Swal.fire({
        //                     title: "Gagal",
        //                     text: text,
        //                     icon: "error"
        //                 });
        //             }
        //         }
        //     }).fail(function(jqXHR, textStatus, errorThrown) {
        //         errorAlertServer('Response Not Found, Please Check Your Data');
        //     });
        // });

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
