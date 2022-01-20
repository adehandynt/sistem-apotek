<?php

namespace App\Exports;
use App\Models\ListItem;
use App\Models\Pembelian;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Illuminate\Contracts\View\View; //Harus diimport untuk men-convert blade menjadi file excel
use Maatwebsite\Excel\Concerns\FromView; //Harus diimport untuk men-convert blade menjadi file excel
use Auth;
use Illuminate\Http\Request;
 
class ExportLaba implements FromView
{
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $tanggal = substr(decrypt($this->request->input('id')),0,7);
         $data = DB::select("SELECT
        COALESCE(labarugi.penjualan_barang,0) as penjualan_barang ,
        COALESCE(labarugi.penjualan_obat,0) as penjualan_obat ,
        COALESCE(labarugi.piutang_obat,0) as piutang_obat ,
        COALESCE(labarugi.pendapatan_jasa_lain,0) as pendapatan_jasa_lain,
        COALESCE(labarugi.pendapatan_jasa_dokter,0) as pendapatan_jasa_dokter,
        COALESCE(labarugi.pembelian_barang,0) as pembelian_barang,
        COALESCE(labarugi.pembelian_obat,0) as pembelian_obat,
        COALESCE(labarugi.barang_hilang,0) as barang_hilang,
        COALESCE(labarugi.obat_hilang,0) as obat_hilang,
        COALESCE(labarugi.pengembalian_barang,0) as pengembalian_barang
        FROM
        (
        SELECT
        ( SELECT
        sum(b.jumlah*c.harga_jual) as totalBarang

        FROM
        transaksi a
        JOIN item_penjualan b ON b.no_transaksi = a.no_transaksi
        JOIN (
        SELECT
        barang.*,
        harga.harga_jual
        FROM
        barang
        JOIN tipe ON barang.kode_tipe = tipe.kode_tipe
        JOIN set_harga ON set_harga.kode_barang = barang.kode_barang
        JOIN harga ON harga.id_harga = set_harga.id_harga
        WHERE
        tipe.jenis_barang = 'barang_lain'
        ) c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE
        a.tgl_transaksi LIKE '".$tanggal."%'
        AND ( a.bpjs IS NULL OR a.bpjs = 0 ) ) AS penjualan_barang,
        ( SELECT
        sum(b.jumlah*c.harga_jual) as totalBarang

        FROM
        transaksi a
        JOIN item_penjualan b ON b.no_transaksi = a.no_transaksi
        JOIN (
        SELECT
        barang.*,
        harga.harga_jual
        FROM
        barang
        JOIN tipe ON barang.kode_tipe = tipe.kode_tipe
        JOIN set_harga ON set_harga.kode_barang = barang.kode_barang
        JOIN harga ON harga.id_harga = set_harga.id_harga
        WHERE
        tipe.jenis_barang = 'obat'
        ) c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE
        a.tgl_transaksi LIKE '".$tanggal."%'
        AND ( a.bpjs IS NULL OR a.bpjs = 0 ) ) AS penjualan_obat,
        ( SELECT sum( total ) FROM transaksi WHERE tgl_transaksi LIKE '".$tanggal."%' AND bpjs IS NOT NULL AND bpjs != 0
        ) AS piutang_obat,
        ( SELECT sum( biaya ) FROM jasa_lain WHERE created_at LIKE '".$tanggal."%' ) AS pendapatan_jasa_lain,
        (
        SELECT
        sum( a.biaya )
        FROM
        tindakan a
        JOIN list_tindakan b ON a.id_tindakan = b.id_tindakan
        WHERE
        b.created_at LIKE '".$tanggal."%'
        ) AS pendapatan_jasa_dokter,
        ( SELECT sum( b.total ) FROM orders a
        JOIN list_order b ON b.id_order = a.id_order
        JOIN barang c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE a.tgl_order LIKE '".$tanggal."%' AND d.jenis_barang = 'barang_lain' ) AS pembelian_barang,
        ( SELECT sum( b.total ) FROM orders a
        JOIN list_order b ON b.id_order = a.id_order
        JOIN barang c ON b.kode_barang = c.kode_barang
        JOIN tipe d ON d.kode_tipe = c.kode_tipe
        WHERE a.tgl_order LIKE '".$tanggal."%' AND d.jenis_barang = 'obat' ) AS pembelian_obat,
        (
        SELECT
        ( sum( a.jml_keluar ) * d.harga_jual ) AS pengembalian
        FROM
        history_barang a
        JOIN barang b ON a.kode_barang = b.kode_barang
        JOIN set_harga c on c.kode_barang=b.kode_barang
        JOIN harga d on d.id_harga = c.id_harga
        WHERE
        a.tgl_keluar LIKE '".$tanggal."%'
        AND a.jenis_history = 'retur_beli'
        ) AS pengembalian_barang,
        (
            SELECT
            sum( a.retur_nominal ) AS pengembalian_jual
            FROM
            retur_penjualan a
            WHERE
            a.tgl_retur LIKE '".$tanggal."%'
            ) AS pengembalian_barang_jual,
        ( SELECT sum( jml_keluar ) FROM history_barang WHERE tgl_keluar LIKE '".$tanggal."%'
        AND jenis_history = 'obat_hilang' ) AS barang_hilang,
        ( SELECT sum( jml_keluar ) * d.harga_jual FROM
        history_barang a
        JOIN barang b ON a.kode_barang = b.kode_barang
        JOIN set_harga c on c.kode_barang=b.kode_barang
        JOIN harga d on d.id_harga = c.id_harga
        WHERE a.tgl_keluar LIKE '".$tanggal."%'
        AND a.jenis_history = 'barang_hilang' ) AS obat_hilang
        FROM
        transaksi
        ) labarugi");
        
        $exp_tgl=explode('-', substr(decrypt($this->request->input('id')),0,7));
        $tanggal = \Carbon\Carbon::createFromDate($exp_tgl[0], $exp_tgl[1], 1)->format('F Y');
        
        //dd($this->request->id);
        return view('laporan/export_excel_laba', [
            'data' =>$data,
            'tanggal'=>$tanggal

        ]);
    }
}
