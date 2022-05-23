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
                        <h4 class="page-title">Akun</h4>
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
                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Tambah Akun</button>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>NIP</th>
                                            <th>Nama</th>
                                            <th>Username</th>
                                            <th>Status</th>
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
                    <h4 class="modal-title" id="myCenterModalLabel">Data Akun</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-akun">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label">NIP</label>
                            <select class="form-control" id="nip" name="nip">
                                @foreach ($data as $item)
                                <option value="{{$item->nip}}">{{$item->nip}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" placeholder="Enter your username">
                        </div>
                        <div class="mb-3">
                            <label for="position" class="form-label">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="custom-modal-reset" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Reset Password</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-password">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="position" class="form-label">Password Baru</label>
                            <input type="hidden" class="form-control" id="id" name="id">
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" name="password" class="form-control" placeholder="Enter your password">
                                <div class="input-group-text" data-password="false">
                                    <span class="password-eye"></span>
                                </div>
                            </div>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
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
        $('#default-datatable').DataTable();

        var table = $('#basic-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/data-akuns',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: "nip"
                },
                {
                    data: "nama_staf"
                },
                {
                    data: "username"
                },
                {
                    data: "status"
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
        $("#form-akun").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-akun')[0]);
            $.ajax({
                url: '{{ url("add-akun") }}',
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
                        $('#form-akun')[0].reset();
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

        $("#form-password").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-password')[0]);
            $.ajax({
                url: '{{ url("update-akun") }}',
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
                        $('#custom-modal-reset').modal('toggle');
                        $('#form-password')[0].reset();
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
                            url: '/delete-akun',
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
                url: '{{ url("edit-satuan") }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    $('#id').val(id);
                    $.each(e, function(key, value) {
                        $('#' + key).val(value);
                    });
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                errorAlertServer('Response Not Found, Please Check Your Data');
            });
        });

        $('#btn-modal').click(function(e) {
            $('#form-akun')[0].reset();
        });

        $('#basic-datatables tbody').on('click', '.btn-reset', function() {
            var id = $(this).data("id");
            $('#id').val(id);
        });

        $('#basic-datatables tbody').on('click', '.btn-disable', function() {
            var id = $(this).data("id");
            var status = $(this).attr('data-status')=='1' ? '0':'1';
            swal.fire({
                    title: "Anda Yakin?",
                    text: "Akun tidak akan dapat digunakan selama berstatus Non-Aktif, dan Dapat diakses jika ber status Aktif",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya, Ubah Status Akun!",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    e.value ?
                        $.ajax({
                            type: "POST",
                            url: '/disable-akun',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id,
                                status: status
                            }
                        }).done(function(msg) {
                            datob = JSON.parse(msg);
                            $('#basic-datatables').DataTable().ajax.reload();
                            if (datob != 'error') {
                                swal.fire("Data telah diubah!", {
                                    icon: "success",
                                });
                            } else {
                                swal.fire("Data gagal diubah!", {
                                    icon: "error",
                                });
                            }
                        }):swal.fire("Data anda aman !");

                });
        });

    </script>
@endsection
