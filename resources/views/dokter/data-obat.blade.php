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
                            <h4 class="page-title">Data Obat</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row justify-content-between mb-2">
                                    <div class="col-sm-12">
                                    </div><!-- end col-->
                                </div>

                                <div class="table-responsive">
                                    <table class="table table-centered table-nowrap table-hover mb-0" id="basic-datatables">
                                        <thead>
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Tipe</th>
                                                <th>Satuan</th>
                                                <th>Jumlah per Satuan</th>
                                                <th>Sisa</th>
                                                <th>Expired</th>
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

    <script>
        $(document).ready(function() {
            $('#kode_barang').focus();
            $('#form-barang')[0].reset();
        });
        $('#default-datatable').DataTable();


        var table = $('#basic-datatables').DataTable({
            lengthChange: false,
            //buttons: ['copy', 'excel', 'pdf', 'print', 'colvis']
            buttons: [],
            ajax: {
                url: '/list-obat',
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
                    data: "nama_tipe"
                },
                {
                    data: "satuan"
                },
                {
                    data: "jml_per_satuan"
                },
                {
                    data: "sisa"
                },
                {
                    data: "tgl_exp"
                }
            ],
            initComplete: function() {
                table.buttons().container()
                    .appendTo('#example_wrapper .col-md-6:eq(0)');
            }
        });
        $("#form-barang").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-barang')[0]);
            $.ajax({
                url: '{{ url('add-barang') }}',
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
                        $('#form-barang')[0].reset();
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
                            url: '/delete-barang',
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
                url: '{{ url("edit-barang") }}',
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
                        if (key == 'kode_satuan') {
                            $("#satuan select").val(value).change();
                        } else if (key == 'kode_tipe') {
                            $("#tipe_barang select").val(value).change();
                        }
            
                        if(key == 'status_ecer' && value=='1'){
                            $("#status_ecer").prop('checked', true);
                        }else if(key == 'status_ecer' && value=='0' ){
                            $("#status_ecer").prop('checked', false);
                        }
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
            $('#form-barang')[0].reset();
        });

        $('#harga_beli, #margin').on('input', function() {
            let harga = $('#harga_beli').val();
            $('#harga_jual').val(((parseInt(harga)) + parseInt(harga * ($('#margin').val()/100))));
        });
    </script>
@endsection
