@extends('main/app')
@section('style')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            background-color: #b0adad !important;
        }

    </style>
@endsection
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <!-- start page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <h4 class="page-title">Jasa Layanan</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <button type="button" id="btn-modal" class="btn btn-danger waves-effect waves-light"
                                            data-bs-toggle="modal" data-bs-target="#custom-modal"><i
                                                class="mdi mdi-plus-circle me-1"></i> Tambah Layanan</button>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th>ID Jasa</th>
                                                <th>Nama Jasa</th>
                                                <th>Harga</th>
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
                        <h4 class="modal-title" id="myCenterModalLabel">Data Jasa</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="form-jasa">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nama Jasa</label>
                                <input type="text" class="form-control" id="nama_jasa" name="nama_jasa"
                                    placeholder="Nama Jasa">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Harga</label>
                                <input type="number" class="form-control numeric_form" id="harga_jasa" name="harga_jasa"
                                    placeholder="Harga Jasa">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Alat</label>
                                <select class="form-control select2-multiple" id="alat" name="alat[]" data-toggle="select2"
                                    data-width="100%" multiple="multiple" required data-placeholder="Choose ...">
                                    <option value="">-Pilih-</option>
                                    @foreach ($obat as $item)
                                        <option value={{ $item->kode_barang }}>{{ $item->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="custom-modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Edit Data Jasa</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="form-jasa-edit">
                            <input type="hidden" class="form-control" id="id_jasa" name="id_jasa">
                            {{ csrf_field() }}
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Nama Jasa</label>
                                <input type="text" class="form-control" id="nama_jasa_edit" name="nama_jasa"
                                    placeholder="Nama Jasa">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Harga</label>
                                <input type="number" class="form-control numeric_form" id="harga_jasa_edit"
                                    name="harga_jasa" placeholder="Harga Jasa">
                            </div>
                            <div class="mb-3">
                                <label for="exampleInputEmail1" class="form-label">Alat</label>
                                <select class="form-control select2-multiple" id="alat_edit" name="alat[]"
                                    data-toggle="select2" data-width="100%" multiple="multiple" required
                                    data-placeholder="Choose ...">
                                    <option value="">-Pilih-</option>
                                    @foreach ($obat as $item)
                                        <option value={{ $item->kode_barang }}>{{ $item->nama_barang }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                    data-bs-dismiss="modal">Batal</button>
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
    <script src="../assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
    <script src="../assets/libs/autonumeric/autoNumeric.min.js"></script>
    <script src="../assets/js/pages/form-masks.init.js"></script>
    <script src="../assets/libs/selectize/js/standalone/selectize.min.js"></script>
    <script>
        $('#alat').select2({
            dropdownParent: $('#custom-modal')
        });
        $('#alat_edit').select2({
            dropdownParent: $('#custom-modal-edit')
        });
        $('#default-datatable').DataTable();


        var table = $('#basic-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/list-jasa',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: "id_list_jasa"
                },
                {
                    data: "nama"
                },
                {
                    data: "harga"
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
        $("#form-jasa").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-jasa')[0]);
            $.ajax({
                url: '{{ url('add-jasa') }}',
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
                        $('#custom-modal').modal('toggle');
                        $('#form-jasa')[0].reset();
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

        $("#form-jasa-edit").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-jasa-edit')[0]);
            $.ajax({
                url: '{{ url('update-jasa') }}',
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
                        $('#form-jasa-edit')[0].reset();
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
                            text: "Cek Kembali Data Anda !",
                            icon: "error"
                        });
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
                            url: '/delete-satuan',
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
                url: '{{ url('edit-jasa') }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    let arr = [];
                    $('#id_jasa').val(id);
                    $('#nama_jasa_edit').val(e[0].nama);
                    $('#harga_jasa_edit').val(e[0].harga);
                    $.each(e, function(key, value) {
                        arr.push(value.kode_barang);
                    });
                     $('#alat_edit').val(arr).change();
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                swal.fire("Response Not Found, Please Check Your Data", {
                    icon: "error",});
            });
        });

        $('#btn-modal').click(function(e) {
            $('#form-jasa')[0].reset();
        });
    </script>
@endsection
