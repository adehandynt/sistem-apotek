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
                                        <button type="button" class="btn btn-light mb-2 me-1">Import</button>
                                        <button type="button" class="btn btn-light mb-2">Export</button>
                                    </div>
                                </div><!-- end col-->
                            </div>
    
                            <div class="table-responsive">
                                <table class="table table-centered table-nowrap table-striped" id="products-datatable">
                                    <thead>
                                        <tr>
                                            <th style="width: 20px;">
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck1">
                                                    <label class="form-check-label" for="customCheck1">&nbsp;</label>
                                                </div>
                                            </th>
                                            <th>NIK</th>
                                            <th>Nama Pasien</th>
                                            <th>Tanggal Lahir</th>
                                            <th>Jenis Kelamin</th>
                                            <th>Umur</th>
                                            <th>Alamat</th>
                                            <th>No Telepon</th>
                                            <th>BPJS</th>
                                            <th style="width: 85px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck2">
                                                    <label class="form-check-label" for="customCheck2">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                2229088192778
                                            </td>
                                            <td class="table-user">
                                                <a href="javascript:void(0);" class="text-body fw-semibold">Paul J. Friend</a>
                                            </td>
                                            <td>
                                                12/02/1985
                                            </td>
                                            <td>
                                                Pria
                                            </td>
                                            <td>
                                                36
                                            </td>
                                            <td>
                                                Arcamanik
                                            </td>
                                            <td>
                                                082993281983
                                            </td>
                                            <td>
                                                937-330-1634
                                            </td>
                                            <td>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                        
                                        <tr>
                                            <td>
                                                <div class="form-check">
                                                    <input type="checkbox" class="form-check-input" id="customCheck3">
                                                    <label class="form-check-label" for="customCheck3">&nbsp;</label>
                                                </div>
                                            </td>
                                            <td>
                                                2229088192799
                                            </td>
                                            <td class="table-user">
                                                <a href="javascript:void(0);" class="text-body fw-semibold">Bryan J. Luellen</a>
                                            </td>
                                            <td>
                                                12/02/1980
                                            </td>
                                            <td>
                                                Pria
                                            </td>
                                            <td>
                                                41
                                            </td>
                                            <td>
                                                Kopo
                                            </td>
                                            <td>
                                                08299328565
                                            </td>
                                            <td>
                                                937-330-2222
                                            </td>
        
                                            <td>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>
                                                <a href="javascript:void(0);" class="action-icon"> <i class="mdi mdi-delete"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <ul class="pagination pagination-rounded justify-content-end mb-0">
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                        <span class="visually-hidden">Previous</span>
                                    </a>
                                </li>
                                <li class="page-item active"><a class="page-link" href="javascript: void(0);">1</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">2</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">3</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">4</a></li>
                                <li class="page-item"><a class="page-link" href="javascript: void(0);">5</a></li>
                                <li class="page-item">
                                    <a class="page-link" href="javascript: void(0);" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                        <span class="visually-hidden">Next</span>
                                    </a>
                                </li>
                            </ul>

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
                    <form>
                        <div class="mb-3">
                            <label for="name" class="form-label">NIK</label>
                            <input type="text" class="form-control numeric_form" id="id_supplier" name="id_supplier" placeholder="NIK Pasien">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nama Pasien</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="id_tipe" placeholder="Nama Pasien">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Tanggal Lahir</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="id_tipe" placeholder="Tanggal Lahir">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" name="id_tipe" placeholder="Jenis Kelamin">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Umur</label>
                            <input type="number" class="form-control numeric_form" id="exampleInputEmail1" name="id_tipe" placeholder="Umur">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Alamat</label>
                            <textarea class="form-control" id="exampleInputEmail1" name="id_tipe" placeholder="Alamat"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">Nomor Telepon</label>
                            <input type="number" class="form-control" id="exampleInputEmail1" name="id_tipe" placeholder="Nomor Telepon">
                        </div>
                        <div class="mb-3">
                            <label for="exampleInputEmail1" class="form-label">BPJS</label>
                            <input type="number" class="form-control" id="exampleInputEmail1" name="id_tipe" placeholder="BPJS">
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