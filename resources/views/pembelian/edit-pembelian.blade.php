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
                <form action="{{ url('update-pembelian') }}" method="post">
                    @csrf
                <div class="row">
                    <div class="col-lg-12">

                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-uppercase mt-0 mb-3 bg-light p-2">Data Pembelian</h5>
                                <div class="mb-3">
                                    <label for="product-meta-title" class="form-label">Nomor Surat</label>
                                    <input type="text" class="form-control" name="nomor_surat" id="nomor-surat-pesan"
                                        value="{{ $order[0]->id_order }}" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="product-meta-title" class="form-label">Pengaju</label>
                                    <input type="text" class="form-control" name="pengaju" id="pengaju"
                                        value="{{ $order[0]->order_by }}" readonly required>
                                </div>

                                <div class="mb-3">
                                    <label for="product-meta-keywords" class="form-label">Supplier</label>
                                    <select class="form-control" name="supplier" id="supplier" required>
                                        <option selected value="{{$order[0]->id_supplier}}">{{$order[0]->nama_supplier}}</option>
                                        @foreach ($supplier as $item)
                                        <option value="{{ $item->id_supplier}}">{{ $item->nama_supplier}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label for="product-meta-description" class="form-label">Tanggal</label>
                                    <input type="text" class="form-control" id="tgl_pesan" name="tgl_pesan" value="{{$order[0]->tgl_order}}" readonly required/>
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
                                </div>
                                <div class="table-responsive mt-4">
                                    <table class="table table-borderless table-nowrap table-centered mb-0"
                                        id="table-pesanan">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Kode Barang</th>
                                                <th>Detail</th>
                                                <th>Jumlah</th>
                                                <th>Satuan Beli</th>
                                                <th>Harga (@satuan)</th>
                                                <th>Diskon</th>
                                                <th>Ppn</th>
                                                <th>Total</th>
                                                <th style="width: 50px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $item)
                                            <tr>
                                                <td>
                                                    <input type="hidden" class="form-control id_list_order" name="id_list_order[]" value="{{$item->id_list_order}}" required/>
                                                    <select type="text" class="form-control nama_barang" name="nama_barang[]"  style="width:150px" value="{{$item->kode_barang}}" required>
                                                    <option>{{$item->kode_barang}}</option>
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="text" class="form-control nama" name="nama[]"  readonly  style="width:150px" value='{{$item->nama_barang}}' min='0' required/>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control jumlah" name="jumlah[]"   style="width:150px" value='{{$item->jumlah}}' min='0' required/>
                                                </td>
                                                <td>
                                                    <select class="form-control satuan"
                                                        name="satuan[]" required>
                                                        <option selected value="{{ $item->kode_satuan}}">{{ $item->satuan}}</option>
                                                        @foreach ($satuan as $items)
                                                        <option value="{{ $items->kode_satuan}}">{{ $items->satuan}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control harga" name="harga[]"  style="width:150px" value='{{$item->harga_beli}}' min='0' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control diskon" name="diskon[]"  style="width:150px" value='{{$item->diskon}}' min='0' max='100' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control ppn" name="ppn[]" step="any" style="width:150px" value='10' min='0' max='100' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control total" name="total[]" style="width:150px"  value='{{$item->total}}' min='0' required readonly
                                                         />
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn-delete-item action-icon" data-id="{{ $item->id_list_order}}"> <i
                                                            class="mdi mdi-delete"></i></a>
                                                            <a style="display: none" href="javascript:void(0);" class="btn-delete-item action-icon"> <i
                                                                class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>
                                            @endforeach
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
                                        <button class="btn btn-success" style="float: right; margin-left:10px" id="btn-simpan">Simpan</button>
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
@if(Session::has('alert-success'))
    <script>
            Swal.fire({
                title: 'Sukses!',
                text: '{{Session::get('alert-success')}}',
                icon: 'success',
                button: {
                text: "Ok",
                value: true,
                visible: true,
                className: "btn btn-primary"
            }
        })
    </script>
    @elseif(Session::has('alert-fail'))
    <script>
        Swal.fire({
            title: 'Gagal!',
            text: '{{Session::get('alert-fail')}}',
            icon: 'error',
            button: {
            text: "Ok",
            value: true,
            visible: true,
            className: "btn btn-danger"
        }
    })
</script>
@endif
    <script>
        $(document).ready(function() {
                $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
        });
        $('#btn-barang').click(function(e) {
            $('#table-pesanan tbody').append(`<tr>
                <input type="hidden" class="form-control id_list_order" name="id_list_order[]" value=""/>
                                                
                                                <td>
                                                    <select class="form-control nama_barang mb-2" name="nama_barang[]" data-toggle="select2" data-width="100%"  style="width:150px" required>
                                                    <option value="">-Pilih-</option>
                                                    @foreach ($obat as $item)
                                                <option value={{$item->kode_barang}}>{{$item->kode_barang.' - '.$item->nama_barang}}</option>
                                                @endforeach
                                                </select>
                                                    </td>
                                                    <td>
                                                    <input type="text" class="form-control nama" name="nama[]"  readonly  style="width:150px" min='0' required/>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control jumlah" style="width:150px" name="jumlah[]" value='0' min='0' required />
                                                </td>
                                                <td>
                                                    <select class="form-control satuan" style="width:150px"
                                                        name="satuan[]" required>
                                                        <option>--satuan--</option>
                                                        @foreach ($satuan as $item)
                                                        <option value="{{ $item->kode_satuan}}">{{ $item->satuan}}</option>
                                                        @endforeach
                                                    </select>
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control harga" name="harga[]" style="width:150px" value='0' min='0' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control diskon" name="diskon[]" style="width:150px" value='0' min='0' max='100' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control ppn" name="ppn[]" step="any" style="width:150px" value='10' min='0' max='100' required
                                                         />
                                                </td>
                                                <td>
                                                    <input type="number" class="form-control total" name="total[]" style="width:150px" value='0' min='0' required readonly    
                                                         />
                                                </td>
                                                <td>
                                                    <a href="javascript:void(0);" class="btn-delete action-icon"> <i
                                                            class="mdi mdi-delete"></i></a>
                                                </td>
                                            </tr>`);
                                            $('.nama_barang').select2();
        });
        //$('.nama_barang').select2();
        $('#table-pesanan tbody').on('change', '.harga', function() {
            let idx = $('.harga').index(this);
            if(parseInt($('.diskon').eq(idx).val())==0){
                let total = (parseInt($('.harga').eq(idx).val()) * parseInt($('.jumlah').eq(idx).val()));
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }else{
                let total = (parseInt($('.harga').eq(idx).val())-(parseInt($('.harga').eq(idx).val())*(parseFloat($('.diskon').eq(idx).val())/100))) * parseInt($('.jumlah').eq(idx).val())
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }
            
        });

        $('#table-pesanan tbody').on('change', '.jumlah', function() {
            let idx = $('.jumlah').index(this);
            if(parseInt($('.diskon').eq(idx).val())==0){
                let total = (parseInt($('.harga').eq(idx).val()) * parseInt($('.jumlah').eq(idx).val()));
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }else{
                let total = (parseInt($('.harga').eq(idx).val())-(parseInt($('.harga').eq(idx).val())*(parseFloat($('.diskon').eq(idx).val())/100))) * parseInt($('.jumlah').eq(idx).val())
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }
            
        });

        
        $('#table-pesanan tbody').on('change', '.diskon', function() {
            let idx = $('.diskon').index(this);
            if(parseInt($('.diskon').eq(idx).val())==0){
                let total = (parseInt($('.harga').eq(idx).val()) * parseInt($('.jumlah').eq(idx).val()));
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }else{
                let total = (parseInt($('.harga').eq(idx).val())-(parseInt($('.harga').eq(idx).val())*(parseFloat($('.diskon').eq(idx).val())/100))) * parseInt($('.jumlah').eq(idx).val())
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }
            
        });

        $('#table-pesanan tbody').on('change', '.ppn', function() {
            let idx = $('.ppn').index(this);
            if(parseInt($('.diskon').eq(idx).val())==0){
                let total = (parseInt($('.harga').eq(idx).val()) * parseInt($('.jumlah').eq(idx).val()));
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }else{
                let total = (parseInt($('.harga').eq(idx).val())-(parseInt($('.harga').eq(idx).val())*(parseFloat($('.diskon').eq(idx).val())/100))) * parseInt($('.jumlah').eq(idx).val())
                $('.total').eq(idx).val(total + (total*(parseFloat($('.ppn').eq(idx).val())/100)));
            }
            
        });

        $('#table-pesanan tbody').on('click', '.btn-delete', function() {
            let idx = $('.btn-delete').index(this);
            $(this).closest("tr").remove();

        });

        $('#table-pesanan tbody').on('click', '.btn-delete-item', function() {
            let idx = $('.btn-delete-item').index(this);
            let elements =  $(this).closest("tr");
            var id = $(this).data("id");
            swal.fire({
                    title: "Hapus Item Pembelian?",
                    text: "Data Tidak Dapat Dikembalikan Setelah Dihapus",
                    icon: "warning",
                    showCancelButton: !0,
                    confirmButtonColor: "#28bb4b",
                    cancelButtonColor: "#f34e4e",
                    confirmButtonText: "Ya",
                    cancelButtonText: "Batal"
                })
                .then(function(e) {
                    e.value ?
                    $.ajax({
                            type: "POST",
                            url: '/delete-item-pembelian',
                            data: {
                                _token: "{{ csrf_token() }}",
                                id: id
                            }
                        }).done(function(msg) {
                   elements.remove();
                   $('#btn-simpan').click();
                        })
                        :
                    swal.fire("Data anda aman !");

                });
 

        });

        $('#table-pesanan tbody').on('change', '.nama_barang', function() {
            let idx = $('.nama_barang').index(this);
            if($(this).val()!=null||$(this).val()!=""){
                $.ajax({
                    url: '{{ url("detail-barang-item") }}',
                    type: 'post',
                    dataType: 'json',
                    data: ({
                        _token: "{{ csrf_token() }}",
                        id: $(this).val()
                    }),
                    success: function(e) {
                        $('.harga').eq(idx).val(e.harga_beli);
                        $('.satuan').eq(idx).val(e.kode_satuan);
                        $('.nama').eq(idx).val(e.nama_barang);
                    }
                }).fail(function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                                title: "Gagal",
                                text: "Cek Kembali Data Anda !",
                                icon: "error"
                            });
                });
            }
            
        });

    </script>
@endsection
