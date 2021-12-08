@extends('main/app')
@section('style')
<style>
    .jumlah,.harga,.total  {
        width: 200px;
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
                            <h4 class="page-title">Pembelian</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <form action="{{ url('add-pembelian') }}" method="post">
                    @csrf
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Data Pembelian</h5>

                                <div class="mb-3">
                                    <label for="product-meta-title" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control" name="nomor_surat" id="nomor-surat-pesan"
                                        value="{{ $id_pesan }}" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="product-meta-title" class="form-label">Pengaju</label>
                                    <input type="text" class="form-control" name="nama_pengaju" id="nama_pengaju"
                                        value="{{ $nama_pengaju[0]->nama_staf }}" readonly required>
                                    <input type="hidden" class="form-control" name="pengaju" id="pengaju"
                                        value="{{ $staf }}" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Supplier</label>
                                    <select class="form-control" name="supplier" id="supplier" required>
                                        <option>--Pilih Supplier--</option>
                                        @foreach ($supplier as $item)
                                        <option value="{{ $item->id_supplier}}">{{ $item->nama_supplier}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="product-meta-description" class="form-label">Tanggal</label>
                                    <input type="string" class="form-control" id="tgl_pesan" name="tgl_pesan" value="{{\Carbon\Carbon::now()->timezone('Asia/Jakarta')}}" readonly required/>
                                </div>
                            </div>
                        </div> <!-- end card -->

                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Barang </h5>
                                <div class="row pull-right">
                                    <div class="col-lg-3">
                                        <button type="button"
                                            class="btn btn-success waves-effect waves-light form-control"
                                            id="btn-barang" style="float:right"><i
                                                class="mdi mdi-plus-circle me-1"></i> Tambah Barang</button>
                                    </div>
                                   
                                        <div class="col-lg-9" >
                                            <div class="col-lg-3 alert alert-danger bg-danger text-white border-0" style="float: right;font-size:14px" role="danger">
                                                <p>Isi <strong>Kolom Nama Barang </strong> dengan <strong>Barcode </strong> apabila barang telah tersedia sebelumnya</p>
                                            </div>
                                        </div>
                                </div>
                                <div class="table-responsive mt-4">
                                    <table class="table table-borderless table-nowrap table-centered mb-0"
                                        id="table-pesanan">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Satuan</th>
                                                <th>Harga (@satuan)</th>
                                                <th>Diskon</th>
                                                <th>Total</th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                {{-- <td><input type="text" class="form-control nama_barang" name="nama_barang[]" required/>
                                                </td> --}}
                                                <td><select class="form-control nama_barang mb-2" name="nama_barang[]" data-toggle="select2" required>
                                                    <option value="">-Pilih-</option>
                                                    @foreach ($obat as $item)
                                                <option value={{$item->kode_barang}}>{{$item->kode_barang.' - '.$item->nama_barang}}</option>
                                                @endforeach
                                                </select></td>
                                                <td>
                                                    <input type="number" class="form-control jumlah" name="jumlah[]"  value='0' min='0' required/>
                                                </td>
                                                <td>
                                                    <select class="form-control satuan"
                                                        name="satuan[]" required>
                                                        <option>--satuan--</option>
                                                        @foreach ($satuan as $item)
                                                        <option value="{{ $item->kode_satuan}}">{{ $item->satuan}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control harga" name="harga[]" value='0' min='0' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control diskon" name="diskon[]" value='0' min='0' max='100' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control total" name="total[]"  value='0' min='0' required readonly
                                                         />
                                                </td>
              
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div> <!-- end col-->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12 ">
                                        <button class="btn btn-success" style="float: right; margin-left:10px">Simpan</button>
                                <a class="btn btn-warning" href="{{url('/pembelian')}}" style="float: right;">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
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
    <script>
         
        $('#btn-barang').click(function(e) {
            $('#table-pesanan tbody').append(`<tr>
                                                    <td><select class="form-control nama_barang mb-2" name="nama_barang[]" data-toggle="select2" data-width="100%" required>
                                                    <option value="">-Pilih-</option>
                                                    @foreach ($obat as $item)
                                                <option value={{$item->kode_barang}}>{{$item->kode_barang.' - '.$item->nama_barang}}</option>
                                                @endforeach
                                                </select></td>
                                                <td>
                                                    <input type="number" class="form-control jumlah" name="jumlah[]" value='0' min='0' required />
                                                </td>
                                                <td>
                                                    <select class="form-control satuan"
                                                        name="satuan[]" required>
                                                        <option>--satuan--</option>
                                                        @foreach ($satuan as $item)
                                                        <option value="{{ $item->kode_satuan}}">{{ $item->satuan}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control harga" name="harga[]" value='0' min='0' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control diskon" name="diskon[]" value='0' min='0' max='100' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control total" name="total[]" value='0' min='0' required readonly    
                                                         />
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn-delete action-icon"> <i
                                                            class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>`);
                                            $('.nama_barang').select2();
        });
        $('.nama_barang').select2();
        $('#table-pesanan tbody').on('change', '.harga, .jumlah, .diskon', function() {
            let idx = $('.harga').index(this);
            if(parseInt($('.diskon').eq(idx).val())==0){
                $('.total').eq(idx).val(parseInt($('.harga').eq(idx).val()) * parseInt($('.jumlah').eq(idx)
                .val()));
            }else{
                $('.total').eq(idx).val((parseInt($('.harga').eq(idx).val())-(parseInt($('.harga').eq(idx).val())*(parseInt($('.diskon').eq(idx).val())/100))) * parseInt($('.jumlah').eq(idx)
                .val()));
            }
            
        });

        $('#table-pesanan tbody').on('click', '.btn-delete', function() {
            let idx = $('.btn-delete').index(this);
            $(this).closest("tr").remove();

        });

    </script>
@endsection
