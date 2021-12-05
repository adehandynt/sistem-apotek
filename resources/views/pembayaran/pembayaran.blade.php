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
                        <h4 class="page-title">Pembayaran</h4>
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
                                    <button type="button" id="btn-modal" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Tambah Pembayaran</button>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>ID Pembayaran</th>
                                            <th>Jenis Pembayaran</th>
                                            <th>Metode Pembayaran</th>
                                            <th>Tagihan Pembayaran</th>
                                            <th>Tagihan Terbayar</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Deskripsi</th>
                                            <th>ID Referensi</th>
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Data Pembayaran</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-pembayaran">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Jenis Bayar</label>
                            <input type="text" class="form-control" id="jenis_bayar" name="jenis_bayar" placeholder="Jenis Pembayaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nomor Referensi</label>
                            <input type="text" class="form-control" id="id_referensi" name="id_referensi" placeholder="Nomor Referensi">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Metode Pembayaran</label>
                            <select class="form-control" id="metode_pembayaran" name="metode_pembayaran" placeholder="Metode Pembayaran" required>
                                <option value="transfer">Transfer</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tagihan</label>
                            <input type="number" class="form-control" id="tagihan" name="tagihan" placeholder="Tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Terbayar</label>
                            <input type="number" class="form-control" id="terbayar" name="terbayar" placeholder="Terbayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status Pembayaran</label>
                            <select class="form-control" id="status_bayar" name="status" placeholder="status Pembayaran" required>
                                <option value="lunas">Lunas</option>
                                <option value="belum lunas">Belum Lunas</option>
                                <option value="eom">EOM</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Bayar</label>
                            <input type="date" class="form-control" id="tgl_bayar" name="tgl_bayar" placeholder="Tanggal Bayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi" name="deskripsi" placeholder="Deskripsi" required></textarea>
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

    <div class="modal fade" id="custom-modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Data Pembayaran</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-pembayaran-edit">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Jenis Bayar</label>
                            <input type="hidden" class="form-control" id="id_hidden" name="id_hidden" placeholder="Jenis Pembayaran">
                            <input type="text" class="form-control" id="jenis_bayar_edit" name="jenis_bayar" placeholder="Jenis Pembayaran" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nomor Referensi</label>
                            <input type="text" class="form-control" id="id_referensi_edit" name="id_referensi" placeholder="Nomor Referensi">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Metode Pembayaran</label>
                            <select class="form-control" id="metode_pembayaran_edit" name="metode_pembayaran" placeholder="Metode Pembayaran">
                                <option value="transfer">Transfer</option>
                                <option value="cash">Cash</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tagihan</label>
                            <input type="number" class="form-control" id="tagihan_edit" name="tagihan" placeholder="Tagihan" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Terbayar</label>
                            <input type="number" class="form-control" id="terbayar_edit" name="terbayar" placeholder="Terbayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Status Pembayaran</label>
                            <select class="form-control" id="status_edit" name="status" placeholder="status Pembayaran">
                                <option value="lunas">Lunas</option>
                                <option value="belum lunas">Belum Lunas</option>
                                <option value="eom">EOM</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Bayar</label>
                            <input type="date" class="form-control" id="tgl_bayar_edit" name="tgl_bayar" placeholder="Tanggal Bayar" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Deskripsi</label>
                            <textarea class="form-control" id="deskripsi_edit" name="deskripsi" placeholder="Deskripsi" required></textarea>
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
                url: '/data-pembayaran',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: "id_pembayaran"
                },
                {
                    data: "jenis_bayar"
                },
                {
                    data: "metode_pembayaran"
                },
                {
                    data: "tagihan"
                },
                {
                    data: "terbayar"
                },
                {
                    data: "tgl_bayar"
                },
                {
                    data: "deskripsi"
                },
                {
                    data: "id_referensi"
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
        $("#form-pembayaran").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-pembayaran')[0]);
            $.ajax({
                url: '{{ url("add-pembayaran") }}',
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
                        $('#form-pembayaran')[0].reset();
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

        $("#form-pembayaran-edit").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-pembayaran-edit')[0]);
            $.ajax({
                url: '{{ url("update-pembayaran") }}',
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
                        $('#form-pembayaran-edit')[0].reset();
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
                            url: '/delete-pembayaran',
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
                url: '{{ url("edit-pembayaran") }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    $('#id_hidden').val(id);
                    $.each(e, function(key, value) {
                        $('#' + key+'_edit').val(value);
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

        $('#btn-modal').click(function(e) {
            $('#form-pembayaran')[0].reset();
        });
    </script>
@endsection
