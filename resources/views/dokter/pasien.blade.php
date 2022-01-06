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
                        <h4 class="page-title">Pasien</h4>
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
                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Tambah Pasien</button>
                                </div>
                                <div class="col-sm-8">
                                    <div class="text-sm-end mt-2 mt-sm-0">
                                        {{-- <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                        <button type="button" class="btn btn-light mb-2">Export</button> --}}
                                    </div>
                                </div><!-- end col-->
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="pasien-datatables">
                                    <thead>
                                        <tr>
                                            <th>NIK</th>
                                            <th>Nama Pasien</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
                                            <th>Golongan Darah</th>
                                            <th>BPJS</th>
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
                    <h4 class="modal-title" id="myCenterModalLabel">Tambah Pasien</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-pasien">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label">NIK</label>
                            <input type="number" class="form-control numeric_form" id="nik" name="nik" placeholder="NIK Pasien" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien" name="nama_pasien" placeholder="Nama Pasien" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" placeholder="Tanggal Lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" placeholder="Jenis Kelamin" required>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Umur</label>
                            <input type="number" class="form-control numeric_form" id="umur_pasien" name="umur_pasien" placeholder="Umur" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat_pasien" name="alamat_pasien" placeholder="Alamat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Golongan Darah</label>
                            <select class="form-control" id="golongan_darah" name="golongan_darah" placeholder="Golongan Darah" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nomor Telepon</label>
                            <input type="number" class="form-control numeric_form" value="" id="no_telp_pasien" name="no_telp_pasien" placeholder="Nomor Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">BPJS</label>
                            <input type="number" class="form-control numeric_form" value="" id="no_bpjs" name="no_bpjs" placeholder="BPJS">
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
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Pasien</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-pasien-edit">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label">Medical Record ID</label>
                            <input type="text" class="form-control" id="medical_record_id_edit" name="medical_record_id" placeholder="Medical Record" readonly required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">NIK</label>
                            <input type="number" class="form-control numeric_form" id="nik_edit" name="nik" placeholder="NIK Pasien" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="nama_pasien_edit" name="nama_pasien" placeholder="Nama Pasien" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                            <input type="date" class="form-control" id="tgl_lahir_edit" name="tgl_lahir" placeholder="Tanggal Lahir" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                            <select class="form-control" id="jenis_kelamin_edit" name="jenis_kelamin" placeholder="Jenis Kelamin" required>
                                <option value="pria">Pria</option>
                                <option value="wanita">Wanita</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Umur</label>
                            <input type="number" class="form-control numeric_form" id="umur_pasien_edit" name="umur_pasien" placeholder="Umur" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Alamat</label>
                            <textarea class="form-control" id="alamat_pasien_edit" name="alamat_pasien" placeholder="Alamat" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Golongan Darah</label>
                            <select class="form-control" id="golongan_darah_edit" name="golongan_darah" placeholder="Golongan Darah" required>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="AB">AB</option>
                                <option value="O">O</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nomor Telepon</label>
                            <input type="number" class="form-control numeric_form" value="" id="no_telp_pasien_edit" name="no_telp_pasien" placeholder="Nomor Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">BPJS</label>
                            <input type="number" class="form-control numeric_form" value="" id="no_bpjs_edit" name="no_bpjs" placeholder="BPJS">
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
    <script src="../assets/libs/jquery-mask-plugin/jquery.mask.min.js"></script>
    <script src="../assets/libs/autonumeric/autoNumeric.min.js"></script>
    <script src="../assets/js/pages/form-masks.init.js"></script>

    <script>
            $(document).ready(function() {
            $('#form-pasien')[0].reset();
        });
        $('#default-datatable').DataTable();


        var table = $('#pasien-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/list-pasien',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: "nik"
                },
                {
                    data: "nama_pasien"
                },
                {
                    data: "tgl_lahir"
                },
                {
                    data: "jenis_kelamin"
                },
                {
                    data: "umur_pasien"
                },
                {
                    data: "alamat_pasien"
                },
                {
                    data: "no_telp_pasien"
                },
                {
                    data: "golongan_darah"
                },
                {
                    data: "no_bpjs"
                },
                {
                    data: "action"
                },
                

            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });

        $("#form-pasien").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-pasien')[0]);
            $.ajax({
                url: '{{ url('add-pasien') }}',
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
                        $('#pasien-datatables').DataTable().ajax.reload();
                        $('#custom-modal').modal('toggle');
                        $('#form-pasien')[0].reset();
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

        $("#form-pasien-edit").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-pasien-edit')[0]);
            $.ajax({
                url: '{{ url('update-pasien') }}',
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
                        $('#pasien-datatables').DataTable().ajax.reload();
                        $('#custom-modal-edit').modal('toggle');
                        $('#form-pasien-edit')[0].reset();
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

        $('#pasien-datatables tbody').on('click', '.btn-edit', function() {
            var id = $(this).data("id");
            $.ajax({
                url: '{{ url("edit-pasien") }}',
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

        $('#pasien-datatables tbody').on('click', '.btn-antrian', function() {
            var id = $(this).data("id");
            $.ajax({
                url: '{{ url("add-antrian-pasien") }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    if (e) {
                        Swal.fire({
                            title: "Sukses",
                            text: "Antrian Berhasil Diinput!",
                            icon: "success"
                        });
                    }else{
                        Swal.fire({
                            title: "Gagal",
                            text: "Gagal Menambahkan Antrian!",
                            icon: "error"
                        });
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                errorAlertServer('Response Not Found, Please Check Your Data');
            });

        });



        </script>
        @endsection