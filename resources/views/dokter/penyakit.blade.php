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
                        <h4 class="page-title">Penyakit</h4>
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
                                    <button type="button" id="btn-modal" class="btn btn-danger waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#custom-modal"><i class="mdi mdi-plus-circle me-1"></i> Tambah Penyakit</button>
                                </div>
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>ID Kategori</th>
                                            <th>Deskripsi Kategori</th>
                                            <th>Kode Penyakit</th>
                                            <th>Nama Penyakit</th>
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
        <div class="modal-dialog modal-xl modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h4 class="modal-title" id="myCenterModalLabel">Data Penyakit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-penyakit">
                        {{ csrf_field() }}
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Parent Class Penyakit</label>
                        <select class="form-control parent_class mb-2" id="parent_class" name="parent_class" data-toggle="select2" data-width="100%">
                            <option value="">-Pilih-</option>
                            @foreach ($class as $item)
                        <option value={{$item->parent_class}}>{{$item->parent_class.' - '.$item->description_class}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Sub Class</label>
                        <input type="text" class="form-control" id="sub_class" name="sub_class" placeholder="Sub Class Penyakit">
                    </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Penyakit</label>
                            <input type="text" class="form-control" id="penyakit" name="penyakit" placeholder="Nama Penyakit">
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
                    <h4 class="modal-title" id="myCenterModalLabel">Data Penyakit</h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                </div>
                <div class="modal-body p-4">
                    <form id="form-penyakit-edit">
                        {{ csrf_field() }}
                        <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Parent Class Penyakit</label>
                        <input type="hidden" class="form-control" id="id" name="id" placeholder="Nama penyakit">
                        <select class="form-control parent_class mb-2" id="parent_class_edit" name="parent_class" data-toggle="select2" data-width="100%">
                            <option value="">-Pilih-</option>
                            @foreach ($class as $item)
                        <option value={{$item->parent_class}}>{{$item->parent_class.' - '.$item->description_class}}</option>
                        @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Sub Class</label>
                        <input type="text" class="form-control" id="sub_class_edit" name="sub_class" placeholder="Sub Class Penyakit">
                    </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Penyakit</label>
                            <input type="text" class="form-control" id="nama_penyakit_edit" name="penyakit" placeholder="Nama Penyakit">
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-success waves-effect waves-light">Simpan</button>
                            <button type="button" class="btn btn-danger waves-effect waves-light" data-bs-dismiss="modal">Batal</button>
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
        $('#parent_class').select2({
        dropdownParent: $('#custom-modal')
    });

        var table = $('#basic-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/list-penyakit',
                method: "GET",
                dataSrc: "",
                data: {
                    _token: "{{ csrf_token() }}",
                }
            },
            columns: [{
                    data: "parent_class",
                    render:function ( data, type, row, meta ) {
                      if(row['parent_class']===""){
                          return '-';
                      }else{
                          return row['parent_class'];
                      }
                    }
                },
                {
                    data: "description_class",
                    render:function ( data, type, row, meta ) {
                      if(row['description_class']==null){
                          return '-';
                      }else{
                          return row['description_class'];
                      }
                    }
                },
                {
                    data: "sub_class",
                    render:function ( data, type, row, meta ) {
                      if(row['sub_class']===""){
                          return '-';
                      }else{
                          return row['sub_class'];
                      }
                    }
                },
                {
                    data: "nama_penyakit"
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
        $("#form-penyakit").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-penyakit')[0]);
            $.ajax({
                url: '{{ url("add-penyakit") }}',
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
                        $('#form-penyakit')[0].reset();
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

        $("#form-penyakit-edit").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-penyakit-edit')[0]);
            $.ajax({
                url: '{{ url("update-penyakit") }}',
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
                        $('#form-penyakit-edit')[0].reset();
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
                            url: '/delete-penyakit',
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
                url: '{{ url("edit-penyakit") }}',
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
            $('#form-penyakit')[0].reset();
        });
    </script>
@endsection
