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
 
class ExportPembelianParams implements FromView
{
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $data=Pembelian::join('list_order','list_order.id_order','=','orders.id_order')
        ->leftJoin('staf', 'orders.order_by', '=', 'staf.nip')
        ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
        ->leftjoin('barang','list_order.kode_barang','=','barang.kode_barang')
        ->select('orders.*','supplier.nama_supplier','staf.nama_staf','list_order.*',DB::raw('COALESCE(barang.nama_barang, list_order.kode_barang ) AS nama_barang'));

        if(isset( $this->request->supplier)){
            $data->where('orders.id_supplier', $this->request->supplier);
        }
        else if(isset( $this->request->tgl_awal)){
            $data->where('orders.created_at','>=', $this->request->tgl_awal.'%');
        }
        else if(isset( $this->request->tgl_akhir)){
            $data->where('orders.created_at','<=', $this->request->tgl_akhir.'%');
        }
        $result = $data->groupby('orders.id_order')->get();

        return view('laporan/export_excel_pembelian_params', [
            'data' =>$result
        ]);
    }
}
