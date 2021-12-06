@extends('main/app')
@section('style')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<style>
    .select2-container--default .select2-selection--multiple .select2-selection__choice{
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
                        <h4 class="page-title">Rekam Medis Pasien</h4>
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
                                    <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Tambah Rekam Medis</button>
                                </div>
                                <div class="col-sm-8">

                                </div><!-- end col-->
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="rekam-datatables">
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
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Tambah Rekam Medis</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-rekam">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Pasien</label>
                            
                            <select class="form-control" id="nik" name="nik" data-toggle="select2" data-width="100%">
                                <option value="">-Pilih-</option>
                                @foreach ($pasien as $item)
                                <option value={{$item->nik}}>{{$item->nik}} - {{$item->nama_pasien}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tekanan Darah</label>
                            <input type="text" class="form-control" id="tekanan_darah" name="tekanan_darah" placeholder="Tekanan Darah" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Saturasi Oksigen</label>
                            <input type="text" class="form-control" id="saturasi_oksigen" name="saturasi_oksigen" placeholder="Saturasi Oksigen" required>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Penyakit</label>
                            <select class="form-control select2-multiple"  id="penyakit" name="penyakit[]" data-toggle="select2" data-width="100%" multiple="multiple" required data-placeholder="Choose ...">
                                <option>-Pilih-</option>
                                @foreach ($penyakit as $item)
                                <option value={{$item->id_penyakit}}>{{$item->nama_penyakit}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tindakan</label>
                            <select class="form-control select2-multiple"  id="tindakan" name="tindakan[]" data-toggle="select2" data-width="100%" multiple="multiple" required data-placeholder="Choose ...">
                                <option>-Pilih-</option>
                                @foreach ($tindakan as $item)
                                <option value={{$item->id_tindakan}}>{{$item->tindakan}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col-sm-11">
                            <label for="exampleInputEmail1" class="form-label">Obat</label>
                                </div>
                                <div class="col-sm-1"><a href="javascript:void(0);" class="text-right btn btn-success" id="btn-add">+</a></div>
                            </div>
                            <div id="container_obat">
                                <select class="form-control kode_barang mb-2" name="kode_barang[]" data-toggle="select2" data-width="100%">
                                    <option value="">-Pilih-</option>
                                    @foreach ($obat as $item)
                                <option value={{$item->kode_barang}}>{{$item->nama_barang}}</option>
                                @endforeach
                                </select>
                            <textarea class="form-control dosis mb-2 mt-2" placeholder="Dosis" name="dosis[]"></textarea>
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

    <div class="modal fade" id="custom-modal-rekam" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Daftar Rekam Medis</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    
                    <div class="table-responsive">
                        <table class="table table-centered table-nowrap table-striped" id="daftar-rekam-datatables">
                            <thead>
                                <tr>
                                    <th>No. Rekam Medis</th>
                                    <th>NIK</th>
                                    <th>Pasien</th>
                                    <th>Tanggal Rekam</th>
                                    <th>Dokter</th>
                                    <th style="width: 85px;">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->

    <div class="modal fade" id="custom-modal-detail" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Detail Rekam Medis</h4>
                    <button type="button" class="btn-close btn-close-detail" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-rekam">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Pasien</label>
                            <input type="text" class="form-control" id="nik_detail" name="nik" readonly>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Tekanan Darah</label>
                            <input type="text" class="form-control" id="tekanan_darah_detail" name="tekanan_darah" placeholder="Tekanan Darah" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Saturasi Oksigen</label>
                            <input type="text" class="form-control" id="saturasi_oksigen_detail" name="saturasi_oksigen" placeholder="Saturasi Oksigen" required readonly>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Penyakit</label>
                            <textarea class="form-control"  id="penyakit_detail" name="penyakit" required readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tindakan</label>
                            <textarea class="form-control"  id="tindakan_detail" name="tindakan" required readonly></textarea>
                        </div>
                        <div class="mb-3">
                            <div class="row mb-3">
                                <div class="col-sm-11">
                            <label for="exampleInputEmail1" class="form-label">Obat</label>
                                </div>
                            </div>
                            <div id="container_obat_detail">
                                
                            </div>
                        </div>
                        <div class="text-end">
                            <a class="btn btn-primary waves-effect waves-light btn-close-detail" data-bs-dismiss="modal">Tutup</a>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>

    <div class="modal fade" id="custom-modal-edit" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Edit Pasien</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-rekam-edit">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="name" class="form-label">NIK</label>
                            <input type="number" class="form-control" id="nik_edit" name="nik" placeholder="NIK Pasien" required>
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
                            <input type="number" class="form-control" id="umur_pasien_edit" name="umur_pasien" placeholder="Umur" required>
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
                            <input type="number" class="form-control" value="" id="no_telp_pasien_edit" name="no_telp_pasien" placeholder="Nomor Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">BPJS</label>
                            <input type="number" class="form-control" value="" id="no_bpjs_edit" name="no_bpjs" placeholder="BPJS">
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
    <script src="../assets/libs/selectize/js/standalone/selectize.min.js"></script>
    <script>
            $(document).ready(function() {
            $('#form-rekam')[0].reset();
            $('#custom-modal-detail').modal({backdrop: 'static', keyboard: false});
        });
        $('#default-datatable').DataTable();

        $('#tindakan').select2({
        dropdownParent: $('#custom-modal')
    });
    $('#nik').select2({
        dropdownParent: $('#custom-modal')
    });

    $('.kode_barang').select2({
        dropdownParent: $('#custom-modal')
    });

    $('#penyakit').select2({
        dropdownParent: $('#custom-modal')
    });

        var table = $('#rekam-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/list-pasien-rekam',
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

        $("#form-rekam").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-rekam')[0]);
            $.ajax({
                url: '{{ url('add-rekam') }}',
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
                        $('#rekam-datatables').DataTable().ajax.reload();
                        $('#custom-modal').modal('toggle');
                        $('#form-rekam')[0].reset();
                        $('#tindakan').val("");
                        $('#kode_barang').val("");
                        $('#penyakit').val("");
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

        $("#form-rekam-edit").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-rekam-edit')[0]);
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
                        $('#rekam-datatables').DataTable().ajax.reload();
                        $('#custom-modal-edit').modal('toggle');
                        $('#form-rekam-edit')[0].reset();
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

        $('#rekam-datatables tbody').on('click', '.btn-edit', function() {
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
                 swal.fire("Response Gagal !");
            });
        });

        $('#rekam-datatables tbody').on('click', '.btn-rekam', function () {
            var id = $(this).data("id");

            $('#default-datatable').DataTable();
            $('#daftar-rekam-datatables').DataTable().destroy();
            var table = $('#daftar-rekam-datatables').DataTable({
                lengthChange: false,
                //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
                buttons: [],
                ajax: {
                    url: '/list-rekam',
                    method: "POST",
                    dataSrc: "",
                    data: {
                        _token: "{{ csrf_token() }}",
                        id: id
                    }
                },
                columns: [{
                        data: "id_rekam_medis"
                    },
                    {
                        data: "nik"
                    },
                    {
                        data: "nama_pasien"
                    },
                    {
                        data: "tgl_rekam"
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
        });

        $('#daftar-rekam-datatables tbody').on('click', '.btn-rekam-detail', function() {
            var id = $(this).data("id");
            $.ajax({
                url: '{{ url("detail-rekam") }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    let penyakit="";
                    let tindakan="";
                    $('#nik_detail').val(e[0].nik);
                    $('#tekanan_darah_detail').val(e[0].tekanan_darah);
                    $('#saturasi_oksigen_detail').val(e[0].saturasi_oksigen);
                    let idx=1;
                    let temp1="";
                    let temp2="";
                    let obat_dosis="";
                    $.each(e, function(key, value) {
                        value.tindakan==temp1? "" : tindakan+=" * "+value.tindakan+"\n";
                        value.nama_penyakit==temp2? "" : penyakit+=" * "+value.nama_penyakit+"\n";
                        temp1=value.tindakan;
                        temp2=value.nama_penyakit;
                        obat_dosis +=`<input type="text" class="form-control mb-2" id="kode_barang_detail" name="kode_barang" value="${value.nama_barang}" readonly>
                            <textarea class="form-control dosis mb-2 mt-2" placeholder="Dosis" id="dosis_detail" name="dosis" readonly>${value.dosis}</textarea>`;
                        idx++;
                        
                    });
                    $('#container_obat_detail').html(obat_dosis);
                    $('#penyakit_detail').val(penyakit);
                    $('#tindakan_detail').val(tindakan);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                 swal.fire("Response Gagal !");
            });
        });

        $('#btn-add').click(function(e) {
            $.ajax({
                url: '{{ url("list-obat") }}',
                type: 'get',
                dataType: 'json',
                data:'',
                success: function(e) {
                    let x = '<option value="">Select</option>'
                    $.each(e, function(key, value) {
                        x+='<option value="'+value.kode_barang+'">'+value.nama_barang+'</option>';
                    });
                    $('#container_obat').append(`<select class="form-control kode_barang mb-2 mt-2" name="kode_barang[]" data-toggle="select2" data-width="100%">${x}
                                </select>
                            <textarea class="form-control dosis mt-2 mb-2" placeholder="Dosis" name="dosis[]"></textarea>`);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                 swal.fire("Response Gagal !");
            });
                            
            $('.kode_barang').select2({
                dropdownParent: $('#custom-modal')
            });
        });

        $('.btn-close-detail').click(function(e) {
 
        });



        </script>
        @endsection