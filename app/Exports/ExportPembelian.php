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
 
class ExportPembelian implements FromView
{
    function __construct($request) {
        $this->request = $request;
    }
    public function view(): View
    {
        $id=decrypt($this->request->id);
        //dd($this->request->id);
        return view('laporan\export_excel_pembelian', [
            'data' =>ListItem::whereIn('id_order', function ($query) use ($id) {
                $query->select('id_order')
                    ->from(with(new Pembelian)->getTable())
                    ->where('id', '=', $id);
            })
                ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
                ->leftjoin('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
                ->select('list_order.*', 'satuan.satuan','barang.nama_barang')
                ->get(),
                'order'=> Pembelian::join('staf', 'orders.order_by', '=', 'staf.nip')
                ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
                ->where('orders.id', '=', $id)
                ->select('orders.*', 'supplier.nama_supplier', 'staf.nama_staf')
                ->get()

        ]);
    }
}
