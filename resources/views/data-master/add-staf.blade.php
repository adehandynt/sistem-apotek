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
                            <h4 class="page-title">Tambah Data Staf</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->

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

                <form action="{{ route('add-staf') }}" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Data Staf</h5>
                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">NIK</label>
                                        <input type="number" class="form-control numeric_form" id="product-meta-title"
                                            placeholder="NIK Staf" name="nik">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Nama</label>
                                        <input type="text" class="form-control" id="product-meta-title"
                                            placeholder="Nama Staf" name="nama">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Tempat / Tanggal
                                            Lahir</label>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <input type="text" class="form-control" id="product-meta-title"
                                                    placeholder="Tempat Lahir Staf" name="tempat_lahir">
                                            </div>
                                            <div class="col-md-6"> <input type="date" class="form-control"
                                                    id="product-meta-title" placeholder="Tanggal Lahir Staf"
                                                    name="tgl_lahir"></div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Jenis Kelamin</label>
                                        <select class="form-control" name="jenis_kelamin">
                                            <option value="pria">Pria</option>
                                            <option value="wanita">Wanita</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Umur</label>
                                        <input type="number" class="form-control" id="product-meta-title"
                                            placeholder="Umur Staf" name="umur">
                                    </div>
                                    <div class="mb-3">
                                        <label for="product-meta-keywords" class="form-label">Alamat</label>
                                        <textarea type="text" class="form-control" id="product-meta-keywords"
                                            placeholder="Alamat Staf" name="alamat"></textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="product-meta-title"
                                            placeholder="Email Staf" name="email">
                                    </div>

                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Nomor Telepon</label>
                                        <input type="number" class="form-control numeric_form" id="product-meta-title"
                                            placeholder="Nomor Telepon Staf" name="no_telp">
                                    </div>

                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Pendidikan Terakhir</label>
                                        <input type="text" class="form-control" id="product-meta-title"
                                            placeholder="Nama Staf" name="pendidikan">
                                    </div>

                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Nomor Telepon Kerabat</label>
                                        <input type="number" class="form-control numeric_form" id="product-meta-title"
                                            placeholder="Nomor Telepon Kerabat Staf yang Dapat Dihubungi"
                                            name="no_telp_kerabat">
                                    </div>

                                    <div class="mb-3">
                                        <label for="product-meta-title" class="form-label">Posisi</label>
                                        <select class="form-control" name="posisi">
                                            <option value="manager">Manager</option>
                                            <option value="apoteker">Apoteker</option>
                                            <option value="dokter">Dokter</option>
                                            <option value="owner">Owner</option>
                                        </select>
                                    </div>
                                </div>
                            </div> <!-- end card -->



                        </div> <!-- end col-->
                    </div>
                    <!-- end row -->

                    <div class="row">
                        <div class="col-12">
                            <div class="text-center mb-3">
                                <button type="button" class="btn w-sm btn-danger waves-effect">Batal</button>
                                <button type="submit" class="btn w-sm btn-success waves-effect waves-light">Simpan</button>
                            </div>
                        </div> <!-- end col -->
                    </div>
                    <!-- end row -->
                </form>

                <!-- file preview template -->
                <div class="d-none" id="uploadPreviewTemplate">
                    <div class="card mt-1 mb-0 shadow-none border">
                        <div class="p-2">
                            <div class="row align-items-center">
                                <div class="col-auto">
                                    <img data-dz-thumbnail src="#" class="avatar-sm rounded bg-light" alt="">
                                </div>
                                <div class="col ps-0">
                                    <a href="javascript:void(0);" class="text-muted fw-bold" data-dz-name></a>
                                    <p class="mb-0" data-dz-size></p>
                                </div>
                                <div class="col-auto">
                                    <!-- Button -->
                                    <a href="" class="btn btn-link btn-lg text-muted" data-dz-remove>
                                        <i class="dripicons-cross"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


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
    <!-- Select2 js-->
    <script src="../assets/libs/select2/js/select2.min.js"></script>
    <!-- Dropzone file uploads-->
    <script src="../assets/libs/dropzone/min/dropzone.min.js"></script>

    <!-- Quill js -->
    <script src="../assets/libs/quill/quill.min.js"></script>

    <!-- Init js-->
    <script src="../assets/js/pages/form-fileuploads.init.js"></script>

    <!-- Init js -->
    <script src="../assets/js/pages/add-product.init.js"></script>
@endsection
