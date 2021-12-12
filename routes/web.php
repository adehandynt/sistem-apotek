<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\StafController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\TipeController;
use App\Http\Controllers\SatuanController;
use App\Http\Controllers\AkunController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\DokterController;
use App\Http\Controllers\JasaController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\MarginController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [AuthController::class, 'showFormLogin'])->name('login');
Route::get('login', [AuthController::class, 'showFormLogin'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showFormRegister'])->name('register');
Route::post('register', [AuthController::class, 'register']);
 
Route::group(['middleware' => 'auth'], function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/pembelian', function () {
    return view('pembelian/pembelian');
});
Route::get('/pembayaran', function () {
    return view('pembayaran/pembayaran');
});
Route::get('/data-barang', function () {
    return view('data-master/obat');
});
Route::get('/data-jasa', function () {
    return view('data-master/jasa');
});
Route::get('/data-pasien', function () {
    return view('dokter/pasien');
});
Route::get('/data-tindakan', function () {
    return view('dokter/tindakan');
});
Route::get('/data-jasa', [JasaController::class, 'v_jasa']);


Route::get('/data-staf', [StafController::class, 'v_list_staf'])->name('data-staf');
Route::get('/add-data-staf', [StafController::class, 'v_add_staf']);
Route::post('/add-staf', [StafController::class, 'add_staf'])->name('add-staf');
Route::post('/edit-staf', [StafController::class, 'edit_staf'])->name('edit-staf');
Route::post('/update-staf', [StafController::class, 'update_staf']);
Route::get('/data-supplier', function () {
    return view('data-master/supplier');
});
Route::get('/data-tipe', [TipeController::class, 'v_tipe'])->name('data-tipe');
Route::get('/data-tipes', [TipeController::class, 'v_list_tipe']);
Route::post('/add-tipe', [TipeController::class, 'add_tipe'])->name('add-tipe');
Route::post('/edit-tipe', [TipeController::class, 'edit_tipe'])->name('edit-tipe');
Route::post('/update-tipe', [TipeController::class, 'update_tipe']);
Route::post('/delete-tipe', [TipeController::class, 'delete_tipe']);

Route::get('/data-satuan', [SatuanController::class, 'v_satuan'])->name('data-satuan');
Route::get('/data-satuans', [SatuanController::class, 'v_list_satuan']);
Route::post('/add-satuan', [SatuanController::class, 'add_satuan'])->name('add-satuan');
Route::post('/edit-satuan', [SatuanController::class, 'edit_satuan'])->name('edit-satuan');
Route::post('/update-satuan', [SatuanController::class, 'update_satuan']);
Route::post('/delete-satuan', [SatuanController::class, 'delete_satuan']);

Route::get('/data-akun', [AkunController::class, 'v_akun'])->name('data-akun');
Route::get('/data-akuns', [AkunController::class, 'v_list_akun']);
Route::post('/add-akun', [AkunController::class, 'add_akun'])->name('add-akun');
Route::post('/edit-akun', [AkunController::class, 'edit_akun'])->name('edit-akun');
Route::post('/update-akun', [AkunController::class, 'update_akun']);
Route::post('/delete-akun', [AkunController::class, 'delete_akun']);
Route::post('/disable-akun', [AkunController::class, 'disable_akun']);

Route::get('/data-supplier', [SupplierController::class, 'v_supplier'])->name('data-supplier');
Route::get('/data-suppliers', [SupplierController::class, 'v_list_supplier']);
Route::post('/add-supplier', [SupplierController::class, 'add_supplier'])->name('add-supplier');
Route::post('/edit-supplier', [SupplierController::class, 'edit_supplier'])->name('edit-supplier');
Route::post('/update-supplier', [SupplierController::class, 'update_supplier']);
Route::post('/delete-supplier', [SupplierController::class, 'delete_supplier']);

Route::get('/data-barang', [ObatController::class, 'v_obat'])->name('data-barang');
Route::get('/data-barangs', [ObatController::class, 'v_list_obat']);
Route::post('/add-barang', [ObatController::class, 'add_obat'])->name('add-barang');
Route::post('/edit-barang', [ObatController::class, 'edit_obat'])->name('edit-barang');
Route::post('/update-barang', [ObatController::class, 'update_obat']);
Route::post('/delete-barang', [ObatController::class, 'delete_obat']);

Route::get('/penjualan', [PenjualanController::class, 'v_penjualan']);
Route::get('/data-penjualans', [PenjualanController::class, 'v_list_penjualan']);
Route::get('/get-produk', [PenjualanController::class, 'get_produk']);
Route::get('/get-produk-other', [PenjualanController::class, 'get_produk_other']);
Route::post('/add-penjualan', [PenjualanController::class, 'add_penjualan'])->name('add-penjualan');
Route::post('/edit-penjualan', [PenjualanController::class, 'edit_penjualan'])->name('edit-penjualan');
Route::post('/update-penjualan', [PenjualanController::class, 'update_penjualan']);
Route::post('/delete-penjualan', [PenjualanController::class, 'delete_penjualan']);

Route::get('/stock', [StockController::class, 'v_stock'])->name('data-stock');
Route::get('/stock-opname', [StockController::class, 'v_stock_opname']);
Route::get('/data-stocks', [StockController::class, 'v_list_stock']);
Route::get('/data-stock-opname', [StockController::class, 'v_list_stock_opname']);
Route::get('/detail-stock-opname', [StockController::class, 'get_list_opname']);
Route::post('/order-list', [StockController::class, 'getOrderID']);
Route::post('/detail-list', [StockController::class, 'detail_list']);
Route::post('/add-stock', [StockController::class, 'add_stock'])->name('add-stock');
Route::post('/add-opname', [StockController::class, 'add_opname']);
Route::post('/edit-stock', [StockController::class, 'edit_stock'])->name('edit-stock');
Route::post('/update-stock', [StockController::class, 'update_stock']);
Route::post('/delete-stock', [StockController::class, 'delete_stock']);
Route::get('/get-stock-produk', [StockController::class, 'get_stock_produk']);
Route::get('/get-grn', [StockController::class, 'get_grn']);

Route::get('/data-pembelian', [PembelianController::class, 'v_pembelian'])->name('data-pembelian');
Route::get('/data-pembelian-restock', [PembelianController::class, 'v_pembelian_restock'])->name('data-pembelian-restock');
Route::get('/data-pembelians', [PembelianController::class, 'v_list_pembelian']);
Route::post('/detail-pembelians', [PembelianController::class, 'detail_barang']);
Route::post('/detail-barang-pembelian', [PembelianController::class, 'detail_barang_pembelian']);
Route::post('/detail-order-po', [PembelianController::class, 'detail_order']);
Route::post('/add-pembelian', [PembelianController::class, 'add_pembelian'])->name('add-pembelian');
Route::get('/edit-pembelian', [PembelianController::class, 'edit_pembelian']);
Route::post('/update-pembelian', [PembelianController::class, 'update_pembelian']);
Route::post('/delete-pembelian', [PembelianController::class, 'delete_pembelian']);
Route::post('/acc-pembelian', [PembelianController::class, 'acc_pembelian']);
Route::get('/export-excel', [PembelianController::class, 'export_excel']);
Route::get('/cetak-pdf', [PembelianController::class, 'cetak_pdf']);

Route::get('/data-retur', [PembelianController::class, 'v_list_retur']);
Route::get('/retur-pembelian', [PembelianController::class, 'v_retur_pembelian'])->name('retur-pembelian');
Route::post('/detail-retur', [PembelianController::class, 'detail_retur']);
Route::post('/retur-barang-pembelian', [PembelianController::class, 'retur_barang_pembelian']);
Route::post('/history-retur', [PembelianController::class, 'history_retur']);
Route::get('/cetak-pdf-retur', [PembelianController::class, 'cetak_pdf_retur']);

Route::get('/data-obat', [DokterController::class, 'v_obat'])->name('data-obat');
Route::get('/list-obat', [DokterController::class, 'list_obat'])->name('list-obat');
Route::get('/list-pasien', [DokterController::class, 'list_pasien'])->name('list-pasien');
Route::get('/list-pasien-rekam', [DokterController::class, 'list_pasien_rekam'])->name('list-pasien-rekam');
Route::post('/add-pasien', [DokterController::class, 'add_pasien'])->name('add-pasien');
Route::post('/edit-pasien', [DokterController::class, 'edit_pasien'])->name('edit-pasien');
Route::post('/update-pasien', [DokterController::class, 'update_pasien'])->name('update-pasien');
Route::get('/list-tindakan', [DokterController::class, 'list_tindakan'])->name('list-tindakan');
Route::post('/delete-tindakan', [DokterController::class, 'delete_tindakan']);
Route::post('/add-tindakan', [DokterController::class, 'add_tindakan'])->name('add-tindakan');
Route::post('/edit-tindakan', [DokterController::class, 'edit_tindakan'])->name('edit-tindakan');
Route::post('/update-tindakan', [DokterController::class, 'update_tindakan'])->name('update-tindakan');
Route::get('/data-medis', [DokterController::class, 'v_medis'])->name('data-medis');
Route::post('/add-rekam', [DokterController::class, 'add_rekam'])->name('add-rekam');
Route::post('/list-rekam', [DokterController::class, 'list_rekam_medis'])->name('list-rekam');
Route::post('/detail-rekam', [DokterController::class, 'detail_rekam_medis'])->name('detail-rekam');
Route::post('/get-detail-resep', [DokterController::class, 'get_detail_resep']);

Route::post('/add-pembayaran', [PembayaranController::class, 'add_pembayaran'])->name('add-pembayaran');
Route::get('/data-pembayaran', [PembayaranController::class, 'data_pembayaran']);
Route::post('/edit-pembayaran', [PembayaranController::class, 'edit_pembayaran']);
Route::post('/update-pembayaran', [PembayaranController::class, 'update_pembayaran']);

Route::get('/retur-penjualan', [PenjualanController::class, 'v_retur_penjualan'])->name('retur-penjualan');
Route::get('/data-transaksi', [PenjualanController::class, 'list_transaksi']);
Route::post('/list-produk', [PenjualanController::class, 'list_produk']);
Route::post('/detail-order', [PenjualanController::class, 'detail_order']);
Route::post('/retur-barang-penjualan', [PenjualanController::class, 'add_retur']);

Route::get('/list-laporan', [LaporanController::class, 'list_laporan']);
Route::get('/laporan-pembelian',  [LaporanController::class, 'view_pembelian']);
Route::get('/laporan-penjualan',  [LaporanController::class, 'view_penjualan']);
Route::get('/laporan-narkotika',  [LaporanController::class, 'view_narkotika']);
Route::get('/laporan-konsinyasi',  [LaporanController::class, 'view_konsinyasi']);
Route::get('/laporan-bpjs',  [LaporanController::class, 'view_bpjs']);
Route::get('/laporan-laba-rugi',  [LaporanController::class, 'view_laba']);
Route::post('/print-pembelian', [LaporanController::class, 'print_pembelian']);
Route::post('/print-narkotika-params', [LaporanController::class, 'print_narkotika_param']);
Route::post('/print-penjualan-params', [LaporanController::class, 'print_penjualan_param']);
Route::post('/print-bpjs-params', [LaporanController::class, 'print_bpjs_param']);
Route::post('/print-konsinyasi-params', [LaporanController::class, 'print_konsinyasi_param']);
Route::post('/print-laba-params', [LaporanController::class, 'print_laba_param']);
Route::get('/cetak-pdf-penjualan', [LaporanController::class, 'print_penjualan']);
Route::get('/cetak-pdf-narkotika', [LaporanController::class, 'print_narkotika']);
Route::get('/cetak-pdf-konsinyasi', [LaporanController::class, 'print_konsinyasi']);
Route::get('/cetak-pdf-bpjs', [LaporanController::class, 'print_bpjs']);
Route::get('/cetak-pdf-laba', [LaporanController::class, 'print_laba']);
Route::get('/graph-data', [DashboardController::class, 'GraphData']);

Route::post('/add-jasa', [JasaController::class, 'add_jasa']);
Route::get('/list-jasa', [JasaController::class, 'v_list_jasa']);
Route::post('/edit-jasa', [JasaController::class, 'edit_jasa']);
Route::post('/update-jasa', [JasaController::class, 'update_jasa']);

Route::post('/print-bill', [ReceiptController::class, 'print']);
Route::get('/data-margin', [MarginController::class, 'margin_page']);
Route::get('/list-data-margin', [MarginController::class, 'list_margin_page']);
Route::post('/add-margin', [MarginController::class, 'add_margin']);
Route::post('/update-margin', [MarginController::class, 'update_margin']);
Route::post('/edit-margin', [MarginController::class, 'edit_margin']);