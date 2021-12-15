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
                            <h4 class="page-title">Data Staf</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->


                <div class="row">
                    @if (session('errors'))
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    Something it's wrong:
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (Session::has('success'))
                                <div class="alert alert-success">
                                    {{ Session::get('success') }}
                                </div>
                            @endif
                            @if (Session::has('error'))
                                <div class="alert alert-danger">
                                    {{ Session::get('error') }}
                                </div>
                            @endif
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-sm-12">
                                        <a class="btn btn-danger waves-effect waves-light" href="/add-data-staf"><i
                                                class="mdi mdi-plus-circle me-1"></i> Tambah Staf</a>
                                    </div>
                                </div>

                                <div class="table-responsive">
                                    <table id="basic-datatable" class="table dt-responsive nowrap w-100">
                                        <thead>
                                            <tr>
                                                <th>NIP</th>
                                                <th>Nama</th>
                                                <th>Posisi</th>
                                                <th>Telepon</th>
                                                <th>Email</th>
                                                <th>Data Lengkap</th>
                                                <th style="width: 85px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                            <tr>
                                                <td>
                                                    <a href="javascript:void(0);"
                                                        class="text-body fw-semibold">{{$item->nip}}</a>
                                                </td>
                                                <td class="table-user">
                                                    <a href="javascript:void(0);" class="text-body fw-semibold">{{$item->nama_staf}}</a>
                                                </td>
                                                <td>
                                                    {{$item->posisi}}
                                                </td>
                                                <td>
                                                    {{$item->no_telp}}
                                                </td>
                                                <td>
                                                    {{$item->email}}
                                                </td>
                                                <td>
                                                    <button type="button" class="btn btn-primary waves-effect waves-light data-lengkap"
                                                        data-bs-toggle="modal" data-bs-target="#custom-modal" data-id="{{$item->id}}"><i
                                                            class="mdi mdi-account-details"></i></button>
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" class="action-icon" data-id="{{$item->id}}"> <i
                                                            class="mdi mdi-square-edit-outline"></i></a>
                                                    <a href="javascript:void(0);" class="action-icon"  data-id="{{$item->id}}"> <i
                                                            class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
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
                        <h4 class="modal-title" id="myCenterModalLabel">Detail Staf</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form action="{{ url('update-staf') }}" method="post">
                            @csrf
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Data Staf</h5>
                                        <div class="mb-3">
                                            <input type="hidden" class="form-control" id="id" name="id">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">NIK</label>
                                            <input type="number" class="form-control numeric_form"
                                                placeholder="NIK Staf" id="nik" name="nik">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Nama</label>
                                            <input type="text" class="form-control"
                                                placeholder="Nama Staf" id="nama_staf" name="nama">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Tempat / Tanggal
                                                Lahir</label>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <input type="text" class="form-control"
                                                        placeholder="Tempat Lahir Staf" id="tempat_lahir" name="tempat_lahir">
                                                </div>
                                                <div class="col-md-6"> <input type="date" class="form-control"
                                                        placeholder="Tanggal Lahir Staf" id="tgl_lahir" name="tgl_lahir"></div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Jenis Kelamin</label>
                                            <input type="text" class="form-control" 
                                                placeholder="Jenis Kelamin Staf"  id="jenis_kelamin" name="jenis_kelamin">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Umur</label>
                                            <input type="number" class="form-control"
                                                placeholder="Umur Staf" id="umur" name="umur">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-meta-keywords" class="form-label">Alamat</label>
                                            <textarea type="text" class="form-control"
                                                placeholder="Alamat Staf" id="alamat" name="alamat"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Email</label>
                                            <input type="email" class="form-control"
                                                placeholder="Email Staf" id="email" name="email">
                                        </div>

                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Nomor Telepon</label>
                                            <input type="number" class="form-control numeric_form"
                                                placeholder="Nomor Telepon Staf" id="no_telp" name="no_telp">
                                        </div>

                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Pendidikan
                                                Terakhir</label>
                                            <input type="text" class="form-control"
                                                placeholder="Nama Staf" id="pend_terakhir" name="pendidikan">
                                        </div>

                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Nomor Telepon
                                                Kerabat</label>
                                            <input type="number" class="form-control numeric_form"
                                                placeholder="Nomor Telepon Kerabat Staf yang Dapat Dihubungi" id="no_kerabat" name="no_telp_kerabat">
                                        </div>
                                        <div class="mb-3">
                                            <label for="product-meta-title" class="form-label">Posisi</label>
                                            <select class="form-control" id="posisi" name="posisi">
                                                <option value="manager">Manager</option>
                                                <option value="apoteker">Apoteker</option>
                                                <option value="dokter">Dokter</option>
                                                <option value="owner">Owner</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                          
                            </div> <!-- end card -->
                            
                    <div class="row">
                        <div class="col-12">
                            <div class="text-center mb-3">
                                <button type="button" class="btn w-sm btn-danger waves-effect">Batal</button>
                                <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Simpan</button>
                            </div>
                        </div> <!-- end col -->
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
<script>
//     Swal.fire({
//       title: "Good job!",
//       text: "You clicked the button!",
//       icon: "success"
//   })
$('#basic-datatable tbody').on('click', '.data-lengkap', function() {
    var id = $(this).data("id");
    $.ajax({
            url: '{{ url("edit-staf") }}',
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
                    if(key=="posisi"){
                        $("#posisi select").val("val2").change();
                    }
                });
            }
        }).fail(function(jqXHR, textStatus, errorThrown) {
            errorAlertServer('Response Not Found, Please Check Your Data');
        });
});
  </script>
@endsection

