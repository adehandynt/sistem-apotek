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
                            <h4 class="page-title">Penjualan</h4>
                        </div>
                    </div>
                </div>
                <!-- end page title -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <h4 class="page-title">Barang</h4>
                                        <div class="col-lg-12 mb-3">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="kode_barang_other"
                                                        placeholder="Kode barang" onmouseover="this.focus();">
                                                </div>
                                                <div class="col-lg-3"> 
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#find-barang-modal"
                                                        class="form-control btn btn-success waves-effect waves-light"><i
                                                            class="mdi mdi-magnify"></i> Cari Barang</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-nowrap table-centered mb-0"
                                                id="table-produk-other">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>Satuan</th>
                                                        <th>Margin (%)</th>
                                                        <th>Diskon</th>
                                                        <th>Total</th>
                                                        <th style="width: 50px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <hr style="border-top: 5px solid #444444;">
                                        <h4 class="page-title">Obat</h4>
                                        <div class="col-lg-12 mb-3">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                    <input type="text" class="form-control" id="kode_barang"
                                                        placeholder="Kode barang" onmouseover="this.focus();">
                                                </div>
                                                <div class="col-lg-3">
                                                    <button type="button" data-bs-toggle="modal" data-bs-target="#find-obat-modal"
                                                        class="form-control btn btn-success waves-effect waves-light"><i
                                                        class="mdi mdi-magnify"></i> Cari Obat</button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="table-responsive">
                                            <table class="table table-borderless table-nowrap table-centered mb-0"
                                                id="table-produk">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Produk</th>
                                                        <th>Harga</th>
                                                        <th>Jumlah</th>
                                                        <th>Satuan</th>
                                                        <th>Margin (%)</th>
                                                        <th>Tuslah</th>
                                                        <th>Diskon</th>
                                                        <th>Total</th>
                                                        <th style="width: 50px;"></th>
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                </tbody>
                                            </table>
                                        </div>
                                        <hr style="border-top: 5px solid #444444;">
                                      
                                        <div class="col-lg-12 mb-3">
                                            <div class="row">
                                                <div class="col-lg-9">
                                                        <h4 class="page-title">Jasa Layanan</h4>
                                                </div>
                                                <div class="col-lg-3">
                                                            <button type="button"
                                                                class="btn btn-secondary waves-effect waves-light form-control"
                                                                id="btn-layanan" style="float:right"><i
                                                                    class="mdi mdi-plus-circle"></i> Layanan</button>
                                                </div>
                                            </div>
                                        </div>
                                        <form id="form-layanan-racik">
                                            <div class="table-responsive">
                                                <table class="table table-borderless table-nowrap table-centered mb-0"
                                                    id="table-layanan">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Jasa</th>
                                                            <th>Biaya</th>
                                                            <th>Jumlah</th>
                                                            <th>Total</th>
                                                            <th style="width: 50px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <select class="form-control layanan mb-2" name="layanan[]" style="width:250px" data-toggle="select2">
                                                                    <option value="">-Pilih-</option>
                                                                    @foreach ($jasa as $item)
                                                                <option value={{$item->id_list_jasa}}>{{$item->nama}}</option>
                                                                @endforeach
                                                                </select>
                                                                <input type="hidden" class="form-control id_jasa" name="id_jasa[]" value=""/>
                                                                {{-- <input type="text" class="form-control layanan"
                                                                    name="layanan[]" /> --}}
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control biaya"
                                                                    name="biaya[]" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control jml_layanan"
                                                                    name="jml_layanan[]" value="1" min='0' />
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control total_biaya"
                                                                    name="total_biaya[]" readonly />
                                                            </td>
                                                            <td>
                                                                <a href="javascript:void(0);" data-id="'.$data[$i]->id.'"
                                                                    class="btn-delete-layanan action-icon"> <i
                                                                        class="mdi mdi-delete"></i></a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <hr style="border-top: 5px solid #444444;">
                                            <div class="col-lg-12 mb-3">
                                                <div class="row">
                                                    <div class="col-lg-9">
                                                            <h4 class="page-title">Dokter</h4>
                                                    </div>
                                                    <div class="col-lg-3">
                                                                {{-- <button type="button"
                                                                    class="btn btn-primary waves-effect waves-light form-control"
                                                                    id="btn-racik" style="float:right"><i
                                                                        class="mdi mdi-plus-circle"></i> Obat
                                                                    Racik</button> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-control">
                                                <label for="example-textarea" class="form-label">Rekam Medis:</label>
                                                <select class="form-control" id="id_rekam" name="id_rekam" data-toggle="select2" data-width="100%">
                                                    <option value="">-Pilih-</option>
                                                    @foreach ($rekam as $item)
                                                    <option value={{$item->id_rekam_medis}}>{{$item->id_rekam_medis}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="table-responsive mt-4">
                                                <table class="table table-borderless table-nowrap table-centered mb-0"
                                                    id="table-racik">
                                                    <thead class="table-light">
                                                        <tr>
                                                            <th>Obat</th>
                                                            <th>Harga</th>
                                                            <th>Margin</th>
                                                            <th>Dosis</th>
                                                            <th>Jumlah</th>
                                                            <th>Tuslah</th>
                                                            <th>Total</th>
                                                            <th style="width: 50px;"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                            <td><input type="text" class="form-control racik"
                                                                    name="racik[]" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control harga_racik"
                                                                    name="harga_racik[]" />
                                                            </td>
                                                            <td>
                                                                <input type="number" min="1" value="0" class="margin_racik form-control"
                                                                        placeholder="Qty" name="margin_racik[]">
                                                                    </td>
                                                            <td>
                                                                <input type="text" class="form-control dosis_racik"
                                                                    name="dosis_racik[]" />
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control jml_racik"
                                                                    value='0' name="jml_racik[]" />
                                                            </td>
                                                            <td>
                                                                <input type="number" min="1" value="0" class="tuslah_racik form-control"
                                                                    placeholder="Qty" name="tuslah_racik[]" style="width: 90px;">
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control total_racik"  value="0"
                                                                    name="total_racik[]" readonly />
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </form>

                                        <!-- Add note input-->
                                        {{-- <div class="mt-3">
                                            <label for="example-textarea" class="form-label">Catatan:</label>
                                            <textarea class="form-control" id="example-textarea" rows="3"
                                                placeholder="Write some note.."></textarea>
                                        </div> --}}

                                        <!-- action buttons-->

                                    </div>
                                    <!-- end col -->

                                    <div class="col-lg-4">
                                        <div class="border p-3 mt-4 mt-lg-0 rounded">
                                            <h4 class="header-title mb-3">Tagihan</h4>
                                            <form id="form-tagihan">
                                                <div class="table-responsive">
                                                    <table class="table mb-0">
                                                        <tbody>
                                                            <tr>
                                                                <td>Barang / Obat :</td>
                                                                <td><input type="hidden" min="1" id="sub_total"
                                                                        class="sub_total form-control" placeholder="Qty"
                                                                        name="sub_total" value="0" style="width: 90px;">
                                                                    Rp <span id="disp_sub_total">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Diskon : </td>
                                                                <td><input type="hidden" min="1" id="diskon"
                                                                        class="form-control" placeholder="Qty"
                                                                        name="diskon" value="0" style="width: 90px;">
                                                                    Rp <span id="disp_diskon">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Jasa / Layanan : </td>
                                                                <td><input type="hidden" min="1" id="total_jasa"
                                                                        class="total_jasa form-control" placeholder="Qty"
                                                                        name="total_jasa" value="0" style="width: 90px;">
                                                                    Rp <span id="disp_total_jasa">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Obat Racik : </td>
                                                                <td><input type="hidden" min="1" id="total_raciks"
                                                                        class="total_raciks form-control" placeholder="Qty"
                                                                        name="total_racik" value="0" style="width: 90px;">
                                                                    Rp <span id="disp_total_racik">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <td>Jasa Dokter: </td>
                                                                <td><input type="hidden" min="1" id="total_dokter"
                                                                        class="total_dokter form-control" placeholder="Qty"
                                                                        name="total_dokter" value="0" style="width: 90px;">
                                                                    Rp <span id="disp_total_dokter">0</span></td>
                                                            </tr>
                                                            <tr>
                                                                <th>Total :</th>
                                                                <th><input type="hidden" min="1" id="grand_total"
                                                                        class="grand_total form-control" placeholder="Qty"
                                                                        name="grand_total" value="0" style="width: 90px;">
                                                                    Rp <span id="disp_grand_total">0</span></th>
                                                            </tr>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                            <!-- end table-responsive -->
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-sm-12">
                                                <div class="text-sm-end">
                                                    <button type="button" id="btn-checkout"
                                                        class="col-sm-12 btn btn-danger waves-effect waves-light"
                                                        data-bs-toggle="modal" data-bs-target="#custom-modal"><i
                                                            class="mdi mdi-plus-circle me-1"></i> Checkout</button>
                                                </div>
                                            </div> <!-- end col -->
                                        </div> <!-- end row-->

                                        {{-- <div class="alert alert-warning mt-3" role="alert">
                                            Diskon Produk <strong>Tolak Angin</strong> 25%
                                        </div> --}}

                                    </div> <!-- end col -->

                                </div> <!-- end row -->
                            </div> <!-- end card-body-->
                        </div> <!-- end card-->
                    </div> <!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->
        <div class="modal fade" id="custom-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Checkout</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <form id="form-bill">
                            {{ csrf_field() }}
                            <div class="col-lg-12">
                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                    <h4 class="header-title mb-3 text-center">Apotek Sindangsari Farma</h4>
                                    <p class="mb-3">No : xxxx</p>
                                    <p class="mb-3">Kasir : {{$staf[0]->nama_staf}}</p>
                                    <p class="mb-3">Tanggal Transaksi :
                                        {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta') }}</p>
                                    <hr>
                                    <h4 class="header-title mb-3">Item</h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0" id="table-bill">
                                            <tbody>
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                    <h4 class="header-title mt-3 mb-3">Jasa</h4>

                                    <div class="table-responsive">
                                        <table class="table mb-0" id="table-jasa-bill">
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <h4 class="header-title mt-3 mb-3">Obat Racik</h4>

                                    <div class="table-responsive">
                                        <input type="hidden" id="id_rekam_hidden" name="id_rekam_hidden"/>
                                        <table class="table mb-0" id="table-racik-bill">
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>

                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                    <div class="table-responsive">
                                        <table class="table mb-0" id="table-total-bill">
                                            <tbody>
                                                <tr>
                                                    <td>Dokter :</td>
                                                    <td>Rp <span id="bill-dokter">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Sub Total :</td>
                                                    <td>Rp <span id="bill-sub-total">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Diskon : </td>
                                                    <td>Rp <span id="bill-diskon">0</span></td>
                                                </tr>
                                                <tr>
                                                    <td>Tuslah <i>(Sudah termasuk pada Sub Total)</i> </td>
                                                    <td><input type="hidden" class="form-control" value="0" id="bill-tuslah-total"
                                                        name="bill_tuslah_total" min="0">Rp <span id="bill-tuslah">0</span></td>
                                                </tr>
                                                <tr>
                                                    <th>Total :</th>
                                                    <th><input type="hidden" class="form-control" value="0" id="bill-grand-total"
                                                        name="bill_grand_total" placeholder="Grand Total" min="0">
                                                        <input type="hidden" class="form-control" value="0" id="bill-total"
                                                        name="bill_total" min="0">Rp <span id="bill-total2">0</span></th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>

                                <div class="border p-3 mt-4 mt-lg-0 rounded">
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr>
                                                    <td>Pembayaran </td>
                                                    <td><select class="metode_pembayaran form-control"
                                                            id="metode_pembayaran" name="metode_pembayaran">
                                                            <option value='cash' selected>Cash</option>
                                                            <option value='debitkredit'>Debit/Kredit</option>
                                                            <option value='bpjs'>BPJS</option>
                                                        </select></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table mb-0">
                                            <tbody>
                                                <tr id="container-bank" style="display:none;">
                                                    <td>Bank </td>
                                                    <td><select class="bank_pembayaran form-control"
                                                            id="bank_pembayaran" name="bank_pembayaran">
                                                            <option value='bri'>BRI</option>
                                                            <option value='mandiri'>MANDIRI</option>
                                                            <option value='bca'>BCA</option>
                                                            <option value='bni'>BNI</option>
                                                        </select></td>
                                                </tr>
                                                <tr id="container-no_kartu" style="display:none;">
                                                    <td>No. Kartu </td>
                                                    <td><input type="number" class="form-control" value="" id="no_kartu"
                                                            name="no_kartu" placeholder="Nomor Kartu"></td>
                                                </tr>
                                                <tr id="container-no_bpjs" style="display:none;">
                                                    <td>No. BPJS </td>
                                                    <td><input type="number" class="form-control" value="0" id="no_bpjs"
                                                            name="no_bpjs" placeholder="Nomor BPJS" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Diterima </td>
                                                    <td><input type="number" class="form-control" value="0" id="uang_diterima"
                                                            name="uang_diterima" placeholder="Uang Diterima" min="0" required></td>
                                                </tr>
                                                <tr>
                                                    <td>Kembali </td>
                                                    <td><input type="hidden" name="uang_kembali" id="uang_kembali" value='0'><span id="kembali"> </span></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <!-- end table-responsive -->
                                </div>

                                <div class="alert alert-warning mt-3" role="alert">
                                    Pastikan Uang yang <strong>diterima</strong> dan <strong>kembalian</strong> telah sesuai
                                    !
                                </div>

                            </div> <!-- end col -->
                            <div class="text-end">
                                <button id="btn-print-bill" class="btn btn-success waves-effect waves-light">Checkout dan
                                    Print</button>
                                <button type="button" class="btn btn-danger waves-effect waves-light"
                                    data-bs-dismiss="modal">Batal</button>
                            </div>
                        </form>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="find-obat-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Cari Obat</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <select class="form-control cari_obat mb-2" id="cari_obat" name="cari_obat" data-width="100%" data-toggle="select2">
                            <option value="0">-Pilih-</option>
                            @foreach ($obat as $item)
                        <option value={{$item->kode_barang}}>{{$item->kode_barang.' - '.$item->nama_barang.' - Tersedia ('.$item->sisa.')'}}</option>
                        @endforeach
                        </select>
                        <div class="text-end mt-3">
                            <button id="btn-cari-obat" class="btn btn-success waves-effect waves-light">Pilih Obat</button>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="find-barang-modal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h4 class="modal-title" id="myCenterModalLabel">Cari Barang</h4>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body p-4">
                        <select class="form-control cari_barang mb-2" id="cari_barang" name="cari_barang" data-width="100%" data-toggle="select2">
                            <option value="0">-Pilih-</option>
                            @foreach ($barang as $item)
                        <option value={{$item->kode_barang}}>{{$item->kode_barang.' - '.$item->nama_barang.' - Tersedia ('.$item->sisa.')'}}</option>
                        @endforeach
                        </select>
                        <div class="text-end mt-3">
                            <button id="btn-cari-barang" class="btn btn-success waves-effect waves-light">Pilih Barang</button>
                        </div>
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
        $(document).ready(function() {
            $('#kode_barang').val("");
            $('#kode_barang_other').val("");
            $('#kode_barang').focus();
            $('#form-tagihan')[0].reset();
            $('#form-layanan-racik')[0].reset();
            $('#id_rekam').select2();
            $('.layanan').select2();
            $('#cari_barang').select2({
                dropdownParent: $('#find-barang-modal')
            });
            $('#cari_obat').select2({
                dropdownParent: $('#find-obat-modal')
            });

            $('#metode_pembayaran').val("cash");
            $(window).keydown(function(event){
                    if(event.keyCode == 13) {
                    event.preventDefault();
                    return false;
                    }
                });
        });

        var kode = "";
        var timer = null;
        $('#kode_barang').on('change', function() {
            kode = $('#kode_barang').val();
            if (kode != null) {
                clearTimeout(timer);
                timer = setTimeout(doStuff('1'), 1000)
            }
        });

        $('#kode_barang_other').on('change', function() {
            kode = $('#kode_barang_other').val();
            if (kode != null) {
                clearTimeout(timer);
                timer = setTimeout(doStuff('2'), 1000)
            }
        });

        $('#btn-cari-obat').click(function(e) {
            let kode_cari = $('#cari_obat').val();
            $('#kode_barang').val(kode);
            kode=kode_cari;
            $('#find-obat-modal').modal('toggle');
            $("#cari_obat").val("0").trigger('change');
            doStuff('1');
        });

        $('#btn-cari-barang').click(function(e) {
            let kode_cari = $('#cari_barang').val();
            $('#kode_barang_other').val(kode_cari);
            kode=kode_cari;
            $('#find-barang-modal').modal('toggle');
            $("#cari_barang").val("0").trigger('change');
            doStuff('2');
        });

        function doStuff(type) {
            $.ajax({
                url: type==1 ? '{{ url('get-produk') }}' : '{{ url('get-produk-other') }}',
                type: 'get',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    kode: kode
                }),
                success: function(e) {
                    $('#kode_barang').val("");
                    let component = '';

                    if (e.length > 0) {
                        let opt_ecer = e[0].status_ecer == 1 ? `<option value='1'>Ecer</option>` : "";
                        if(type==1){
                            var table = $('#table-produk tbody');
                            table.append(`<tr><td>
                                                                <p class="m-0 d-inline-block align-middle font-14 fw-medium">
                                                                        <a href="ecommerce-product-detail.html" data-kode='${e[0].kode_barang}''
                                                                            class="nama-brg text-reset font-family-secondary">${e[0].nama_barang}</a>
                                                                        <br>
                                                                        <small class="me-2"><b>Satuan:</b> ${e[0].satuan} </small>
                                                                        <small><b>Kategori:</b> ${e[0].nama_tipe}</small>
                                                                    </p>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" min="1" class="harga_beli form-control"
                                                                        placeholder="Qty" name="harga_beli[]" style="width: 90px;" value="${e[0].harga_beli}">
                                                                    <input type="hidden" min="1" class="harga_jual form-control"
                                                                        placeholder="Qty" name="harga_jual[]" style="width: 90px;" value="${e[0].harga_jual}">
                                                                    <input type="hidden" min="1" class="harga_eceran form-control"
                                                                        placeholder="Qty" name="harga_eceran[]" style="width: 90px;" value="${e[0].harga_eceran}">
                                                                    <input type="hidden" min="1" class="diskon form-control"
                                                                        placeholder="Qty" name="diskon[]" style="width: 90px;" value="${e[0].diskon}">
                                                                    ${e[0].satuan} : Rp ${e[0].harga_jual} / <br>Ecer : Rp ${parseFloat(e[0].harga_eceran).toFixed(2)}
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" value="1" class="jml_produk form-control"
                                                                        placeholder="Qty" name="jml_produk[]" style="width: 90px;">
                                                                </td>
                                                                <td>
                                                                    <select class="satuan_produk form-control" style="width: 90px;" name="satuan_produk[]">
                                                                        <option value='${e[0].satuan}'>${e[0].satuan}</option>
                                                                        ${opt_ecer}
                                                                        </select>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" value="${e[0].margin}" class="margin_produk form-control"
                                                                        placeholder="Qty" name="margin_produk[]" style="width: 90px;">
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" value="0" class="tuslah_produk form-control"
                                                                        placeholder="Qty" name="tuslah_produk[]" style="width: 90px;">
                                                                </td>
                                                                <td>
                                                                    <p class="besar_disc">${e[0].diskon} % </p>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" min="1" class="harga_total form-control"
                                                                        placeholder="Qty" name="harga_total[]" style="width: 90px;" value="${e[0].harga_jual-(e[0].harga_jual*(e[0].diskon/100))}">
                                                                    Rp <span class="disp_total"> ${e[0].harga_jual-(e[0].harga_jual*(e[0].diskon/100)).toFixed(2)} </span>
                                                                </td>
                                                                <td>
                                                                    ${e[0].action}
                                                                </td>
                                                            </tr>`);
                        }else{
                            var table = $('#table-produk-other tbody');
                            table.append(`<tr><td>
                                                                <p class="m-0 d-inline-block align-middle font-14 fw-medium">
                                                                        <a href="ecommerce-product-detail.html" data-kode='${e[0].kode_barang}''
                                                                            class="nama-brg text-reset font-family-secondary">${e[0].nama_barang}</a>
                                                                        <br>
                                                                        <small class="me-2"><b>Satuan:</b> ${e[0].satuan} </small>
                                                                        <small><b>Kategori:</b> ${e[0].nama_tipe}</small>
                                                                    </p>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" min="1" class="harga_beli form-control"
                                                                        placeholder="Qty" name="harga_beli[]" style="width: 90px;" value="${e[0].harga_beli}">
                                                                    <input type="hidden" min="1" class="harga_jual form-control"
                                                                        placeholder="Qty" name="harga_jual[]" style="width: 90px;" value="${e[0].harga_jual}">
                                                                    <input type="hidden" min="1" class="harga_eceran form-control"
                                                                        placeholder="Qty" name="harga_eceran[]" style="width: 90px;" value="${e[0].harga_eceran}">
                                                                    <input type="hidden" min="1" class="diskon form-control"
                                                                        placeholder="Qty" name="diskon[]" style="width: 90px;" value="${e[0].diskon}">
                                                                    ${e[0].satuan} : Rp ${e[0].harga_jual} / <br>Ecer : Rp ${parseFloat(e[0].harga_eceran).toFixed(2)}
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" value="1" class="jml_produk form-control"
                                                                        placeholder="Qty" name="jml_produk[]" style="width: 90px;">
                                                                </td>
                                                                <td>
                                                                    <select class="satuan_produk form-control" style="width: 90px;" name="satuan_produk[]">
                                                                        <option value='${e[0].satuan}'>${e[0].satuan}</option>
                                                                        ${opt_ecer}
                                                                        </select>
                                                                    
                                                                </td>
                                                                <td>
                                                                    <input type="number" min="1" value="${e[0].margin}" class="margin_produk form-control"
                                                                        placeholder="Qty" name="margin_produk[]" style="width: 90px;">
                                                                        <input type="hidden" min="1" value="0" class="tuslah_produk form-control"
                                                                        placeholder="Qty" name="tuslah_produk[]" style="width: 90px;">
                                                                    
                                                                </td>
                                                                <td>
                                                                    <p class="besar_disc">${e[0].diskon} % </p>
                                                                </td>
                                                                <td>
                                                                    <input type="hidden" min="1" class="harga_total form-control"
                                                                        placeholder="Qty" name="harga_total[]" style="width: 90px;" value="${e[0].harga_jual-(e[0].harga_jual*(e[0].diskon/100))}">
                                                                    Rp <span class="disp_total"> ${e[0].harga_jual-(e[0].harga_jual*(e[0].diskon/100)).toFixed(2)} </span>
                                                                </td>
                                                                <td>
                                                                    ${e[0].action}
                                                                </td>
                                                            </tr>`);
                        }

                        var sum = 0;
                        $('.harga_total').each(function() {
                            sum += parseFloat($(this).val());
                        });
                        sum = sum.toFixed(2);
                        let sub_total = $('#sub_total').val();
                        let diskon = $('#diskon').val();
                        let grand_total = $('#grand_total').val();

                        if (sub_total == 0) {
                            $('#sub_total').val(e[0].harga_jual);
                            $('#disp_sub_total').text(e[0].harga_jual);
                            $('#diskon').val(e[0].harga_jual * (e[0].diskon / 100));
                            // $('#disp_diskon').text(e[0].harga_jual * (e[0].diskon / 100));
                        } else {
                            $('#sub_total').val(sum);
                            $('#disp_sub_total').text(sum);
                            $('#diskon').val(e[0].harga_jual * (e[0].diskon / 100));
                            // $('#disp_diskon').text(e[0].harga_jual * (e[0].diskon / 100));

                        }

                        // $('#grand_total').val(sum - parseInt(
                        //     diskon));
                        // $('#disp_grand_total').text(sum - parseInt(
                        //     diskon));
                            generate_tagihan();
                    } else {
                        swal.fire("Data Tidak Tersedia!");
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                            title: "Gagal",
                            text: "Cek Kembali Data Anda !",
                            icon: "error"
                        });
            });
        }

        $('#table-produk tbody').on('change', '.satuan_produk', function() {
            let idx = $('.satuan_produk').index(this);
            let total = 0;
            // console.log($(this).val());
            if ($(this).val() == "1") {
                total = ($('.harga_eceran').eq(idx).val() * $('.jml_produk').eq(idx).val());
            } else {
                let harga_jual = ($('.harga_beli').eq(idx).val() * ($('.margin_produk').eq(idx).val()/100))+parseInt($('.harga_beli').eq(idx).val())+parseInt($('.tuslah_produk').eq(idx).val());
                 total = (harga_jual * $('.jml_produk').eq(idx).val());
                //total = ($('.harga_jual').eq(idx).val() * $('.jml_produk').eq(idx).val());
            }
             console.log(total);
            let sub_total = $('#sub_total').val();
            let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
            let diskon_total = $('#diskon').val();
            let grand_total = $('#grand_total').val();
            $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
            var sum = 0;
            $('.harga_total').each(function() {
                sum += parseFloat($(this).val());
            });
            sum = sum.toFixed(2);
            generate_tagihan();
            // $('.disp_total').eq(idx).text(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(2));
            // $('#sub_total').val(parseFloat(total) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
            // $('#disp_sub_total').text(parseFloat(total) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
            $('#diskon').val(diskon * total);
            // $('#disp_diskon').text(diskon * total);
            // $('#grand_total').val(sum - parseInt(diskon_total));
            // $('#disp_grand_total').text(sum - parseInt(diskon_total));
        });

        $('#table-produk tbody').on('change', '.jml_produk', function() {
            let idx = $('.jml_produk').index(this);
            if ($('.satuan_produk').eq(idx).val() != '1') {
                // let total = ($('.harga_jual').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let harga_jual = ($('.harga_beli').eq(idx).val() * ($('.margin_produk').eq(idx).val()/100))+parseInt($('.harga_beli').eq(idx).val())+parseInt($('.tuslah_produk').eq(idx).val());
                let total = (harga_jual * $('.jml_produk').eq(idx).val());
                console.log(idx);
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text((parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2)).toLocaleString('id-ID'));
                $('#sub_total').val(parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon))).toFixed(
                    2));
                $('#disp_sub_total').text((parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)))
                    .toFixed(2)).toLocaleString('id-ID'));
                $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            } else {
                let total = ($('.harga_eceran').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2));
                $('#sub_total').val(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
                $('#disp_sub_total').text((parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2)).toLocaleString('id-ID'));
                // $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            }
            // console.log(1);
            generate_tagihan();
        });

        $('#table-produk tbody').on('change', '.margin_produk', function() {
            let idx = $('.margin_produk').index(this);
            
            if ($('.satuan_produk').eq(idx).val() != '1') {
                let harga_jual = ($('.harga_beli').eq(idx).val() * ($(this).val()/100))+parseInt($('.harga_beli').eq(idx).val())+parseInt($('.tuslah_produk').eq(idx).val());
                let total = (harga_jual * $('.jml_produk').eq(idx).val());
           
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text((parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2)).toLocaleString('id-ID'));
                $('#sub_total').val(parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon))).toFixed(
                    2));
                $('#disp_sub_total').text((parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)))
                    .toFixed(2)).toLocaleString('id-ID'));
                $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            } else {
                let total = ($('.harga_eceran').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2));
                $('#sub_total').val(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
                $('#disp_sub_total').text((parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2)).toLocaleString('id-ID'));
                // $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            }
            // console.log(1);
            generate_tagihan();
        });

        $('#table-produk tbody').on('change', '.tuslah_produk', function() {
            let idx = $('.tuslah_produk').index(this);
            if ($('.satuan_produk').eq(idx).val() != '1') {
                // let total = ($('.harga_jual').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let harga_jual = ($('.harga_beli').eq(idx).val() * ($('.margin_produk').eq(idx).val()/100))+parseInt($('.harga_beli').eq(idx).val())+parseInt($('.tuslah_produk').eq(idx).val());
                let total = (harga_jual * $('.jml_produk').eq(idx).val());
                console.log(idx);
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text((parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2)).toLocaleString('id-ID'));
                $('#sub_total').val(parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon))).toFixed(
                    2));
                $('#disp_sub_total').text((parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)))
                    .toFixed(2)).toLocaleString('id-ID'));
                $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            } else {
                let total = ($('.harga_eceran').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2));
                $('#sub_total').val(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
                $('#disp_sub_total').text((parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2)).toLocaleString('id-ID'));
                // $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            }
            // console.log(1);
            generate_tagihan();
        });

        $('#table-produk-other tbody').on('change', '.margin_produk', function() {
            let idx = $('.margin_produk').index(this);
            
            if ($('.satuan_produk').eq(idx).val() != '1') {
                let harga_jual = ($('.harga_beli').eq(idx).val() * ($(this).val()/100))+parseInt($('.harga_beli').eq(idx).val());
                let total = (harga_jual * $('.jml_produk').eq(idx).val());
           
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text((parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2)).toLocaleString('id-ID'));
                $('#sub_total').val(parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon))).toFixed(
                    2));
                $('#disp_sub_total').text((parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)))
                    .toFixed(2)).toLocaleString('id-ID'));
                $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            } else {
                let total = ($('.harga_eceran').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2));
                $('#sub_total').val(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
                $('#disp_sub_total').text((parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2)).toLocaleString('id-ID'));
                // $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            }
            // console.log(1);
            generate_tagihan();
        });
        

        $('#table-produk-other tbody').on('change', '.satuan_produk', function() {
            let idx = $('.satuan_produk').index(this);
            let total = 0;
            // console.log($(this).val());
            if ($(this).val() == "1") {
                total = ($('.harga_eceran').eq(idx).val() * $('.jml_produk').eq(idx).val());
            } else {
                let harga_jual = ($('.harga_beli').eq(idx).val() * ($('.margin_produk').eq(idx).val()/100))+parseInt($('.harga_beli').eq(idx).val());
                 total = (harga_jual * $('.jml_produk').eq(idx).val());
                //total = ($('.harga_jual').eq(idx).val() * $('.jml_produk').eq(idx).val());
            }
            // console.log(total);
            let sub_total = $('#sub_total').val();
            let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
            let diskon_total = $('#diskon').val();
            let grand_total = $('#grand_total').val();
            $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
            var sum = 0;
            $('.harga_total').each(function() {
                sum += parseFloat($(this).val());
            });
            sum = sum.toFixed(2);
            generate_tagihan();
            // $('.disp_total').eq(idx).text(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(2));
            // $('#sub_total').val(parseFloat(total) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
            // $('#disp_sub_total').text(parseFloat(total) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
            $('#diskon').val(diskon * total);
            // $('#disp_diskon').text(diskon * total);
            // $('#grand_total').val(sum - parseInt(diskon_total));
            // $('#disp_grand_total').text(sum - parseInt(diskon_total));
        });

        $('#table-produk-other tbody').on('change', '.jml_produk', function() {
            let idx = $('.jml_produk').index(this);
            if ($('.satuan_produk').eq(idx).val() != '1') {
                let harga_jual = ($('.harga_beli').eq(idx).val() * ($('.margin_produk').eq(idx).val()/100))+parseInt($('.harga_beli').eq(idx).val());
                let total = (harga_jual * $('.jml_produk').eq(idx).val());
            
               // let total = ($('.harga_jual').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text((parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2)).toLocaleString('id-ID'));
                $('#sub_total').val(parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon))).toFixed(
                    2));
                $('#disp_sub_total').text((parseFloat(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)))
                    .toFixed(2)).toLocaleString('id-ID'));
                $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            } else {
                let total = ($('.harga_eceran').eq(idx).val() * $('.jml_produk').eq(idx).val());
                let sub_total = $('#sub_total').val();
                let diskon = parseFloat($('.diskon').eq(idx).val()) / 100;
                let diskon_total = $('#diskon').val();
                let grand_total = $('#grand_total').val();
                $('.harga_total').eq(idx).val(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)));
                var sum = 0;
                $('.harga_total').each(function() {
                    sum += parseFloat($(this).val());
                });
                sum = sum.toFixed(2);
                $('.disp_total').eq(idx).text(parseFloat(total) - (parseFloat(total) * parseFloat(diskon)).toFixed(
                    2));
                $('#sub_total').val(parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2));
                $('#disp_sub_total').text((parseFloat(sum) + (parseFloat(total) * parseFloat(diskon)).toFixed(2)).toLocaleString('id-ID'));
                // $('#diskon').val(diskon * total);
                // $('#disp_diskon').text((diskon * total).toLocaleString('id-ID'));
                // $('#grand_total').val(sum);
                // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            }
            // console.log(1);
            generate_tagihan();
        });

        $('#btn-layanan').click(function(e) {
            var x = '<option value="">Select</option>'
            $.ajax({
                url: '{{ url("list-jasa") }}',
                type: 'get',
                dataType: 'json',
                data:'',
                success: function(e) {
                    $.each(e, function(key, value) {
                        x+='<option value="'+value.id_list_jasa+'">'+value.nama+'</option>';
                    });
                    $('#table-layanan tbody').append(`<tr><td><select class="form-control layanan mb-2 mt-2" name="layanan[]" data-toggle="select2" data-width="100%">${x}
                                        </select>
                                        <input type="hidden" class="form-contrrol id_jasa" name="id_jasa[]" value=""/>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control biaya" name="biaya[]"/>
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control jml_layanan"
                                                                            name="jml_layanan[]" value="1" min='0' />
                                                                    </td>
                                                                    <td>
                                                                        <input type="number" class="form-control total_biaya" name="total_biaya[]" readonly/>
                                                                    </td>
                                                                    <td>
                                                                    <a href="javascript:void(0);" data-id="'.$data[$i]->id.'" class="btn-delete-layanan action-icon">
                                                                        <i class="mdi mdi-delete"></i></a>
                                                                        </td>
                                                                </tr>`);
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                 swal.fire("Response Gagal !");
            });
            $('.layanan').select2();
        });

        $('#btn-racik').click(function(e) {
            $('#table-racik tbody').append(`<tr><td><input type="text" class="form-control racik" name="racik[]"/>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control harga_racik" name="harga_racik[]"/>
                                                            </td>
                                                            <td>
                                                                <input type="text" class="form-control dosis_racik" name="dosis_racik[]"/>
                                                            </td>
                                                            <td>
                                                                <input type="number" class="form-control jml_racik" value='0' name="jml_racik[]"/>
                                                            </td>
                                                            <td>
                                                               <input type="number" class="form-control total_racik" name="total_racik[]" readonly/>
                                                            </td>
                                                        </tr>`);
        });

        $('#table-layanan tbody').on('change', '.layanan', function() {
            let idx = $('.layanan').index(this);
            $.ajax({
                url: '{{ url('edit-jasa') }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: $('.layanan').eq(idx).val()
                }),
                success: function(e) {
                    let arr = [];
                    $('.biaya').eq(idx).val(e[0].harga);
                    $('.id_jasa').eq(idx).val(e[0].kode_barang);
                    $('.total_biaya').eq(idx).val($('.jml_layanan').eq(idx).val()*e[0].harga);
                    generate_tagihan();
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                swal.fire("Response Not Found, Please Check Your Data", {
                    icon: "error",});
            });
        });

        $('#table-layanan tbody').on('change', '.biaya, .jml_layanan', function() {
            let idx = $('.biaya').index(this);
            $('.total_biaya').eq(idx).val(parseInt($('.biaya').eq(idx).val()) * parseInt($('.jml_layanan').eq(idx)
                .val()));

            var sum = 0;
            var sum_biaya=0;
            $('.harga_total').each(function() {
                sum += parseFloat($(this).val());
            });
            $('.total_biaya').each(function() {
                sum += parseFloat($(this).val());
                sum_biaya += parseFloat($(this).val());
            });
            sum = sum.toFixed(2);
            generate_tagihan();
            // $('#grand_total').val(sum);
            // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            // $('#disp_total_jasa').text(sum_biaya.toLocaleString('id-ID'));

        });

        $('#table-produk tbody').on('click', '.btn-delete', function() {
            let idx = $('.btn-delete').index(this);
            $(this).closest("tr").remove();

        });

        $('#table-produk-other tbody').on('click', '.btn-delete', function() {
            let idx = $('.btn-delete').index(this);
            $(this).closest("tr").remove();

        });

        $('#table-layanan tbody').on('click', '.btn-delete-layanan', function() {
            let idx = $('.btn-delete-layanan').index(this);
            $(this).closest("tr").remove();
            generate_tagihan();
        });

        $('#table-racik tbody').on('change', '.jml_racik,.tuslah_racik', function() {
            let idx = $('.jml_racik').index(this);
            let harga = (parseInt($('.harga_racik_beli').eq(idx).val())*(parseInt($(".margin_racik").val())/100)) + parseInt($('.harga_racik_beli').eq(idx).val())+parseInt($('.tuslah_racik').eq(idx).val());
            let jml = $('.jml_racik').eq(idx).val();
            let racik_fee = 250;
            // console.log(idx + "" + (parseInt(harga)) + "" + racik_fee + "" + jml);
            $('.total_racik').eq(idx).val((parseFloat(harga)) * parseFloat(jml));
            var sum = 0;
            var sum_biaya=0;
            $('.harga_total').each(function() {
                sum += parseFloat($(this).val());
            });
            $('.total_dokter').each(function() {
                sum += parseFloat($(this).val());
            });
            $('.total_biaya').each(function() {
                sum += parseFloat($(this).val());
                sum_biaya += parseFloat($(this).val());
            });
            $('.total_racik').each(function() {
                sum += parseFloat($(this).val());
                sum_biaya += parseFloat($(this).val());
                //console.log(sum_biaya);
            });
            sum = sum.toFixed(2);
            generate_tagihan();
            // $('#grand_total').val(sum);
            // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            // $('#disp_total_racik').text(sum_biaya.toLocaleString('id-ID'));
        });

        $('#table-racik tbody').on('change', '.margin_racik', function() {
            let idx = $('.margin_racik').index(this);
            let harga = (parseInt($('.harga_racik_beli').eq(idx).val())*(parseInt($(this).val())/100)) + parseInt($('.harga_racik_beli').eq(idx).val())+parseInt($('.tuslah_racik').eq(idx).val());
            let jml = $('.jml_racik').eq(idx).val();
            let racik_fee = 250;
            // console.log(idx + "" + (parseInt(harga)) + "" + racik_fee + "" + jml);
            $('.total_racik').eq(idx).val((parseFloat(harga)) * parseFloat(jml));
            var sum = 0;
            var sum_biaya=0;
            $('.harga_total').each(function() {
                sum += parseFloat($(this).val());
            });
            $('.total_dokter').each(function() {
                sum += parseFloat($(this).val());
            });
            $('.total_biaya').each(function() {
                sum += parseFloat($(this).val());
                sum_biaya += parseFloat($(this).val());
            });
            $('.total_racik').each(function() {
                sum += parseFloat($(this).val());
                sum_biaya += parseFloat($(this).val());
                //console.log(sum_biaya);
            });
            sum = sum.toFixed(2);
            generate_tagihan();
            // $('#grand_total').val(sum);
            // $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            // $('#disp_total_racik').text(sum_biaya.toLocaleString('id-ID'));
        });

        function generate_tagihan() {
            var sum = 0;
            var diskon = 0;
            var barang=0;
            var jasa=0;
            var dokter=0;
            var racik=0;
            var total_disc_barang=0;
            
            $('#form-tagihan')[0].reset();
            $('.harga_total').each(function() {
               
                sum += parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
                barang +=parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
            });
            
            $('#sub_total').val(sum);
            $('#disp_sub_total').text(sum.toLocaleString('id-ID'));
            $('.total_biaya').each(function() {
          
                sum += parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
                jasa+=parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
            });
           
            $('.total_racik').each(function() {
            
                sum += parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
                racik +=parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
            
            });

            if(racik>0){
            $('.total_dokter').each(function() {
            
            sum += parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
            dokter +=parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
         });
            }

            $('.diskon').each(function() {
                let idx = $('.diskon').index(this);
                diskon += parseFloat($(this).val()==="" || isNaN($(this).val())?0:$(this).val());
            });
            //sum = sum.toFixed(2);
            $('#grand_total').val(sum);
            $('#disp_diskon').text($('#diskon').val().toLocaleString('id-ID'));
            $('#disp_grand_total').text(sum.toLocaleString('id-ID'));
            $('#disp_total_racik').text(racik.toLocaleString('id-ID'));
            $('#disp_total_jasa').text(jasa.toLocaleString('id-ID'));
            $('#disp_total_dokter').text(dokter.toLocaleString('id-ID'));
            $('#total_dokter').val(dokter);
            $('#total_raciks').val(racik);
            $('#total_jasa').val(jasa);
           // console.log(sum);

        }

        $('#btn-checkout').click(function(e) {
            var grandjml = 0;
            var satuan = 0;
            var grandtotal = 0;
            var besar_disc = "";
            var granddiskon = 0;
            var grandsubtotal = 0;
            var component = "";
            var tuslah=0;

            $('#uang_diterima').val("");
            $('#kembali').text("-");
            if ($('.harga_total').eq(0).val() === null || $('.harga_total').eq(0).val() === "") {
                $("#table-bill tr").remove();
                $('#table-bill tbody').append(`<tr><td> -- Tidak Tersedia -- </td></tr>`);
            } else {
                $("#table-bill tr").remove();
                let idx = 0;
                $('.nama-brg').each(function() {
                    let name = $(this).text();
                    let kode = $(this).attr('data-kode');
                    let jml = $('.jml_produk').eq(idx).val();
                    let satuan = $('.satuan_produk').eq(idx).val();
                    let harga = 0;
                    tuslah+=parseInt($('.tuslah_produk').eq(idx).val());
                    if (satuan == 1) {
                        harga = $('.harga_eceran').eq(idx).val();
                    } else {
                        harga = ($('.harga_beli').eq(idx).val() * ($('.margin_produk').eq(idx).val()/100))+parseInt($('.harga_beli').eq(idx).val())+parseInt($('.tuslah_produk').eq(idx).val());
                        //harga = $('.harga_jual').eq(idx).val();
                    }
                    let total = $('.harga_total').eq(idx).val();
                    let besar_disc = $('.besar_disc').eq(idx).text();

                    grandjml += parseFloat((harga - total));
                    granddiskon += parseFloat((harga * jml - total));
                    grandtotal += parseFloat(total);
                    grandsubtotal += parseFloat(harga * jml);
                    idx++;
                    $('#table-bill tbody').append(
                        `<tr>
                            <td><input type="hidden" name="kode_barang[]" value="${kode}"/></td>
                            <td><input type="hidden" name="nama_barang[]" value="${name}"/>${name}</td>
                            <td><input type="hidden" name="jml_barang[]" value="${jml}"/>${jml}</td>
                            <td><input type="hidden" name="satuan_barang[]" value="${satuan == 1 ? 'Satuan/Eceran' : satuan}"/>${satuan == 1 ? 'Satuan/Eceran' : satuan}</td>
                            <td><input type="hidden" name="hargabarang[]" value="${harga}"/>@ Rp ${harga}</td>
                            <td><input type="hidden" name="disc_barang[]" value="${besar_disc}"/>disc ${besar_disc}</td>
                            <td><input type="hidden" name="total_harga_barang[]" value="${total}"/>Rp ${total}</td>
                        </tr>`
                    );
                });
            }

            // console.log($('.table-jasa').eq(0).val());

            if ($('.total_biaya').eq(0).val() === null || $('.total_biaya').eq(0).val() === "") {
                $("#table-jasa-bill tr").remove();
                $('#table-jasa-bill tbody').append(`<tr><td> -- Tidak Tersedia -- </td></tr>`);
            } else {
                $("#table-jasa-bill tr").remove();
                let idx = 0;
                $('.layanan').each(function() {
                    let name =  $(this).find('option:selected').text();
                    let name_val = $(this).val();
                    let jml = $('.jml_layanan').eq(idx).val();
                    let biaya = $('.biaya').eq(idx).val();
                    let total = $('.total_biaya').eq(idx).val();
                    let id_jasa = $('.id_jasa').eq(idx).val();

                    grandtotal += parseFloat(total);
                    grandsubtotal += parseFloat(total);
                    idx++;
                    $('#table-jasa-bill tbody').append(
                        `<tr>
                            <td><input type="hidden" name="id_jasa[]" value="${id_jasa}"/></td>
                            <td><input type="hidden" name="nama_jasa[]" value="${name_val}"/>${name}</td>
                            <td><input type="hidden" name="jml_jasa[]" value="${jml}"/>${jml}</td>
                            <td><input type="hidden" name="biaya_jasa[]" value="${biaya}"/>@ Rp ${biaya}</td>
                            <td><input type="hidden" name="total_jasa[]" value="${total}"/>Rp ${total}</td>
                            </tr>`
                    );
                });
            }

            if ($('.total_racik').eq(0).val() === null || $('.total_racik').eq(0).val() === "") {
                $("#table-racik-bill tr").remove();
                $('#table-racik-bill tbody').append(`<tr><td> -- Tidak Tersedia -- </td></tr>`);
            } else {
                $("#table-racik-bill tr").remove();
                let idx = 0;
                let totalBiaya=0;
                let doc=0;
                $('.racik').each(function() {
                    let name = $(this).val();
                    let jml = $('.jml_racik').eq(idx).val();
                    let biaya = $('.harga_racik').eq(idx).val();
                    let total = $('.total_racik').eq(idx).val();
                    let id_obat = $('.id_obat').eq(idx).val();
                    let dokter=$('#total_dokter').val();
                    doc=dokter;
                    totalBiaya+=parseFloat(total);
                    grandtotal += parseFloat(total);
                    grandsubtotal += parseFloat(total);
                    tuslah+=parseInt($('.tuslah_racik').eq(idx).val());
                    idx++;
                    $('#table-racik-bill tbody').append(
                        `<tr>
                            <td><input type="hidden" name="jasa_dokter[]" value="${parseFloat(dokter)+totalBiaya}"/></td>
                            <td><input type="hidden" name="id_obat[]" value="${id_obat}"/></td>
                            <td><input type="hidden" name="nama_racik[]" value="${name}"/>${name}</td>
                            <td><input type="hidden" name="jml_racik[]" value="${jml}"/>${jml}</td>
                            <td><input type="hidden" name="biaya_racik[]" value="${biaya}"/>@ Rp ${biaya}</td>
                            <td><input type="hidden" name="total_racik[]" value="${total}"/>Rp ${total}</td>
                            </tr>`
                    );
                });
                $('#bill-dokter').text(doc.toLocaleString('id-ID'));
            }

            if($('#total_dokter').val()!=null || $('#total_dokter').val()!=""){
                grandtotal+=parseFloat($('#total_dokter').val());
                grandsubtotal+=parseFloat($('#total_dokter').val());
            }

            $('#bill-sub-total').text(grandsubtotal.toLocaleString('id-ID'));

            $('#bill-diskon').text(granddiskon.toLocaleString('id-ID'));
            $('#bill-tuslah').text(tuslah.toLocaleString('id-ID'));
            $('#bill-total2').text((Math.ceil(grandtotal/100)*100).toLocaleString('id-ID'));
            $('#bill-total').val(Math.ceil(grandtotal/100)*100);
            $('#bill-grand-total').val(Math.ceil(grandtotal/100)*100);
            $('#bill-tuslah-total').val(tuslah);
        });

        $('#metode_pembayaran').change(function(e) {
            $('#uang_diterima').val("");
            $('#kembali').text("-");
            if ($(this).val() == "cash") {
                $('#container-no_kartu').hide();
                $('#container-no_bpjs').hide();
                $('#container-bank').hide();
                $('#no_kartu').val("");
                $('#uang_kembali').val("");
            } else if ($(this).val() == "debitkredit") {
                $('#container-no_kartu').show();
                $('#container-no_bpjs').hide();
                $('#container-bank').show();
                $('#no_kartu').val("");
                $('#uang_kembali').val("");
            }else{
                let total=$('#bill-grand-total').val();
                $('#uang_diterima').val(total);
                $('#container-no_kartu').hide();
                $('#container-no_bpjs').show();
                $('#container-bank').hide();
                $('#no_kartu').val("");
                $('#no_bpjs').val(0);
                $('#uang_kembali').val(0);
            }
        });

        $('#uang_diterima').keyup(function(e) {
            if ($('#metode_pembayaran').val() == "cash") {
                let total = parseFloat($('#bill-total').val());
                let diterima = $('#uang_diterima').val();
                $('#uang_diterima').val();
                let kembali= diterima - total;
                if(kembali<0){
                    $('#kembali').text(kembali).removeClass().addClass('text-danger');
                }else{
                    $('#kembali').text('+ '+kembali.toLocaleString('id-ID')+' (berlebih)').removeClass().addClass('text-success');
                    $('#uang_kembali').val(kembali);
                }
            } else {
                $('#kembali').text('0').removeClass().addClass('text-primary');
            }
        });

        $("#form-bill").submit(function(event) {
            event.preventDefault();
            var formData = new FormData($('#form-bill')[0]);
            $.ajax({
                url: '{{ url("print-bill") }}',
                type: 'post',
                data: formData,
                contentType: false, //untuk upload image
                processData: false, //untuk upload image
                timeout: 300000, // sets timeout to 3 seconds
                dataType: 'json',
                success: function(e) {
                    Swal.fire({
                            title: "Sukses",
                            text: "Transaksi Berhasil Diinput!",
                            icon: "success"
                        });
                        setTimeout(function(){   location.reload(); }, 2000);                 
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                            title: "Gagal",
                            text: "Gagal Transaksi, Coba Lagi",
                            icon: "error"
                        });
            });
        });

        $('#id_rekam').change(function(e) {
            var id =$(this).val();
            $.ajax({
                url: '{{ url('get-detail-resep') }}',
                type: 'post',
                dataType: 'json',
                data: ({
                    _token: "{{ csrf_token() }}",
                    id: id
                }),
                success: function(e) {
                    
                    if( $('#id_rekam_hidden').val()!=id){
                        $('#id_rekam_hidden').val(id);
                        $("#table-racik tr").eq(1).remove();
                        $('.total_dokter').val(e[0].total_dokter);
                        $('#disp_total_dokter').text(e[0].total_dokter.toLocaleString('id-ID'));
                        for(let i=0;i<e.length;i++){
                            $('#table-racik tbody').append(`<tr><td><input type="hidden" class="form-control id_obat" name="id_obat[]" value="`+e[i].kode_barang+`"/>
                                                                <input type="text" class="form-control racik" name="racik[]" style="width: 150px;" value="`+e[i].nama_barang+`"/>
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control harga_racik" style="width: 110px;" name="harga_racik[]" value="`+(e[i].harga_eceran==0?e[i].harga_jual:e[i].harga_eceran)+`"/>
                                                                    <input type="hidden" class="form-control harga_racik_beli" style="width: 110px;" name="harga_racik_beli[]" value="`+(e[i].harga_beli)+`"/>
                                                                </td>
                                                                <td>
                                                                <input type="number" min="1" value="`+e[i].margin+`" class="margin_racik form-control"
                                                                        placeholder="Qty" name="margin_racik[]" style="width: 110px;">
                                                                    </td>
                                                                <td>
                                                                    <input type="text" class="form-control dosis_racik" style="width: 110px;" name="dosis_racik[]" value="`+e[i].dosis+`"/>
                                                                </td>
                                                                <td>
                                                                    <input type="number" class="form-control jml_racik" style="width: 110px;" value='0' name="jml_racik[]"/>
                                                                </td>
                                                                <td>
                                                                <input type="number" min="1" value="0" class="tuslah_racik form-control"
                                                                    placeholder="Qty" name="tuslah_racik[]" style="width: 90px;">
                                                            </td>
                                                                <td>
                                                                   <input type="number" value="0" class="form-control total_racik" style="width: 110px;" name="total_racik[]" readonly/>
                                                                </td>
                                                            </tr>`);
                        }
                        
                    }else{
                        Swal.fire({
                            title: "Peringatan",
                            text: "Rekam Medis Telah diinput",
                            icon: "warning"
                        });
                    }
                }
            }).fail(function(jqXHR, textStatus, errorThrown) {
                Swal.fire({
                            title: "Gagal",
                            text: "Gagal Transaksi, Coba Lagi",
                            icon: "error"
                        });
            });
        });
        
    </script>
@endsection
