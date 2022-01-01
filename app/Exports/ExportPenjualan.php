<?php

namespace App\Exports;
use App\Models\Penjualan;
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
 
class ExportPenjualan implements FromView
{
    function __construct($date) {
        $this->date = $date;
    }
    public function view(): View
    {
        //export adalah file export.blade.php yang ada di folder views
        return view('laporan\export_pdf_excel_penjualan', [
            //data adalah value yang akan kita gunakan pada blade nanti
            //User::all() mengambil seluruh data user dan disimpan pada variabel data
            'data' => Penjualan:: join('item_penjualan', 'transaksi.no_transaksi', '=', 'item_penjualan.no_transaksi')
            ->join('barang','item_penjualan.kode_barang','=','barang.kode_barang')
            ->leftJoin('staf', 'transaksi.nip', '=', 'staf.nip')
            ->select('transaksi.*','barang.nama_barang','staf.nama_staf','item_penjualan.jumlah')
            ->where('tgl_transaksi','like',$this->date.'%')
            ->get()
        ]);
    }
}