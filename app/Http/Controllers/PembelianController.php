<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Pembelian;
use App\Models\Harga;
use App\Models\SetHarga;
use App\Models\Stok;
use App\Models\Supplier;
use App\Models\ListItem;
use App\Models\Staf;
use App\Models\HistoryBarang;
use Validator;
use Hash;
use Session;
use Auth;
use PDF;
use DB;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use App\Exports\ListItemExport;
use App\Models\ReturPembelian;
use Maatwebsite\Excel\Facades\Excel;


class PembelianController extends Controller
{

    public function v_pembelian()
    {
        $res = [];
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'orders', 'field' => 'id_order', 'length' => 15, 'prefix' => 'ORD-' . $year . '-']);
        $res['id_pesan'] = 'ORD-' . $year.'-XXXX';
        $res['staf'] = Auth::user()->nip;
        $res['nama_pengaju'] = Staf::where('nip','=',Auth::user()->nip)->select('nama_staf')->get();
        $res['supplier'] = Supplier::orderby('created_at', 'DESC')
            ->get();
        $res['satuan'] = Satuan::orderby('created_at', 'DESC')
            ->get();

        return view('pembelian/create-pembelian', $res);
    }
    public function v_pembelian_restock()
    {
        $res = [];
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'orders', 'field' => 'id_order', 'length' => 15, 'prefix' => 'ORD-' . $year . '-']);
        $res['id_pesan'] = 'ORD-' . $year.'-XXXX';
        $res['staf'] = Auth::user()->nip;
        $res['nama_pengaju'] = Staf::where('nip','=',Auth::user()->nip)->select('nama_staf')->get();
        $res['supplier'] = Supplier::orderby('created_at', 'DESC')
            ->get();
        $res['satuan'] = Satuan::orderby('created_at', 'DESC')
            ->get();
            $res['obat']= Obat::where('kode_barang','!=',null)->get();
        return view('pembelian/create-pembelian-restock', $res);
    }
    public function v_retur_pembelian()
    {
        $res = [];
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'orders', 'field' => 'id_order', 'length' => 15, 'prefix' => 'ORD-' . $year . '-']);
        $res['id_pesan'] = $id;
        $res['staf'] = Auth::user()->nip;
        $res['nama_pengaju'] = Staf::where('nip','=',Auth::user()->nip)->select('nama_staf')->get();
        $res['supplier'] = Supplier::orderby('created_at', 'DESC')
            ->get();
        $res['satuan'] = Satuan::orderby('created_at', 'DESC')
            ->get();
        return view('pembelian/retur-pembelian', $res);
    }
    public function v_list_pembelian(Request $request)
    {
        $data = Pembelian::leftJoin('staf', 'orders.order_by', '=', 'staf.nip')
            ->select('orders.*', 'staf.nama_staf')
            ->orderby('created_at', 'DESC')
            ->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-detail" data-id="' . $data[$i]->id . '" data-bs-toggle="modal" data-bs-target="#custom-modal"> <i class="mdi mdi-eye"></i></a>
            <a href="/edit-pembelian?id=' . encrypt($data[$i]->id) . '" class="action-icon" data-id="' . $data[$i]->id . '"> <i class="mdi mdi-square-edit-outline"></i></a>';
            if ($data[$i]->status == 1) {
                $data[$i]->stat_pengajuan = '<h5><span class="badge bg-soft-success text-success"><i class="mdi mdi-shield-check"></i> Disetujui</span></h5>';
                $data[$i]->stat_pembelian = $data[$i]->status_pembelian == 1 ? ' <h5><span class="badge bg-soft-success text-success"><i class="mdi mdi-shield-check"></i> Diterima</span></h5>' : '<h5><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-clock-outline"></i> Belum Diterima</span></h5>';
                $data[$i]->action .= '<a href="cetak-pdf?id=' . encrypt($data[$i]->id) . '" class="action-icon" data-id="' . $data[$i]->id . '"> <i class="mdi mdi-printer-check"></i></a><a href="export-excel-pembelian?id=' . encrypt($data[$i]->id) . '" class="action-icon" data-id="' . $data[$i]->id . '"> <i class="mdi mdi-file-excel"></i></a>';
            } elseif ($data[$i]->status == 2) {
                $data[$i]->stat_pengajuan = '<h5><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-close-circle-outline"></i> Ditolak</span></h5>';
                $data[$i]->stat_pembelian = '<h5><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-bitcoin"></i> Menunggu Persetujuan</span></h5>';
            } else {
                $data[$i]->stat_pengajuan = '<h5><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-clock-outline"></i> Menunggu</span></h5>';
                $data[$i]->stat_pembelian = '<h5><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-clock-outline"></i> Menunggu Persetujuan</span></h5>';
            }
        }
        return json_encode($data);
    }

    public function v_list_retur(Request $request)
    {
        $data = Pembelian::leftJoin('staf', 'orders.order_by', '=', 'staf.nip')
            ->where('status_pembelian','1')
            ->select('orders.*', 'staf.nama_staf')
            ->orderby('created_at', 'DESC')
            ->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = '<a href="javascript:void(0);" class="action-icon btn-detail" data-id="' . $data[$i]->id_order . '" data-bs-toggle="modal" data-bs-target="#custom-modal"> <i class="mdi mdi-eye"></i></a>
            <a href="javascript:void(0);" class="action-icon btn-retur" data-bs-toggle="modal" data-bs-target="#custom-modal-retur" data-id="' . $data[$i]->id_order . '"> <i class="mdi mdi-square-edit-outline"></i></a>';
            if ($data[$i]->status == 1) {
                $data[$i]->stat_pengajuan = '<h5><span class="badge bg-soft-success text-success"><i class="mdi mdi-shield-check"></i> Disetujui</span></h5>';
                $data[$i]->stat_pembelian = $data[$i]->status_pembelian == 1 ? ' <h5><span class="badge bg-soft-success text-success"><i class="mdi mdi-shield-check"></i> Diterima</span></h5>' : '<h5><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-clock-outline"></i> Belum Diterima</span></h5>';
            } elseif ($data[$i]->status == 2) {
                $data[$i]->stat_pengajuan = '<h5><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-close-circle-outline"></i> Ditolak</span></h5>';
                $data[$i]->stat_pembelian = '<h5><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-bitcoin"></i> Menunggu Persetujuan</span></h5>';
            } else {
                $data[$i]->stat_pengajuan = '<h5><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-clock-outline"></i> Menunggu</span></h5>';
                $data[$i]->stat_pembelian = '<h5><span class="badge bg-soft-warning text-warning"><i class="mdi mdi-clock-outline"></i> Menunggu Persetujuan</span></h5>';
            }
        }
        return json_encode($data);
    }

    public function detail_order(Request $request)
    {
        $id = $request->id;
        if($request->retur==1){
            $order = Pembelian::join('staf', 'orders.order_by', '=', 'staf.nip')
                ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
                ->where('orders.id_order', '=', $id)
                ->select('orders.*', 'supplier.nama_supplier', 'staf.nama_staf')
                ->get();
        }else{
            $order = Pembelian::join('staf', 'orders.order_by', '=', 'staf.nip')
                ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
                ->where('orders.id', '=', $id)
                ->select('orders.*', 'supplier.nama_supplier', 'staf.nama_staf')
                ->get();
        }

        $data = ListItem::whereIn('id_order', function ($query) use ($id) {
            $query->select('id_order')
                ->from(with(new Pembelian)->getTable())
                ->where('id', '=', $id);
        })->get();
        $arr = array('order' => $order, 'data' => $data);
        return json_encode($arr);
    }

    public function detail_barang(Request $request)
    {
        $id = $request->id;
        $data = ListItem::whereIn('list_order.id_order', function ($query) use ($id) {
            $query->select('id_order')
                ->from(with(new Pembelian)->getTable())
                ->where('id', '=', $id);
        })
            ->join('orders', 'orders.id_order', '=', 'list_order.id_order')
            ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
            ->leftjoin('barang','barang.kode_barang','=','list_order.kode_barang')
            ->select('list_order.*', 'satuan.satuan','barang.nama_barang')
            ->get();
        return json_encode($data);
    }

    public function history_retur(Request $request){
        $id = $request->id;
        $data=ReturPembelian::leftjoin('list_order','list_order.id_list_order','=','retur_pembelian.id_list_order')
        ->leftjoin('barang','list_order.kode_barang','=','barang.kode_barang')
        ->leftjoin('orders', 'orders.id_order', '=', 'list_order.id_order')
        ->where('orders.id_order',$id)
        ->select('retur_pembelian.*','barang.nama_barang')
        ->get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->status =  $data[$i]->status==1?'<h5><span class="badge bg-soft-success text-success"><i class="mdi mdi-shield-check"></i> Diterima</span></h5>' : '<h5><span class="badge bg-soft-danger text-danger"><i class="mdi mdi-clock-outline"></i> Belum Diterima</span></h5>';
            $data[$i]->action = '<a href="cetak-pdf-retur?id=' . encrypt($data[$i]->id_retur_beli) . '" class="action-icon" data-id="' . $data[$i]->id_retur_beli . '"> <i class="mdi mdi-printer-check"></i></a>';
        }
        return json_encode($data);
    }

    public function detail_retur(Request $request)
    {
        $id = $request->id;
        // $data = ListItem::
        // leftjoin('barang','list_order.kode_barang','=','barang.kode_barang')
        //     ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
        //     ->join('stok', 'list_order.kode_barang', '=', 'stok.kode_barang')
        //     ->where('stok.id_order', '=', $id)
        //     ->select('list_order.*', 'satuan.satuan','stok.kode_barang','stok.tgl_exp','barang.nama_barang','stok.stock_id')
        //     ->groupBy('stok.kode_barang','stok.stock_id')
        //     ->get();

             $data = ListItem::whereIn('list_order.id_order', function ($query) use ($id) {
            $query->select('id_order')
                ->from(with(new Pembelian)->getTable())
                ->where('id_order', '=', $id);
        })
        ->leftjoin('barang','list_order.kode_barang','=','barang.kode_barang')
            ->join('orders', 'orders.id_order', '=', 'list_order.id_order')
            ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
            ->join('stok', 'list_order.kode_barang', '=', 'stok.kode_barang')
            ->select('list_order.*', 'satuan.satuan','stok.kode_barang','stok.tgl_exp','barang.nama_barang','stok.stock_id')
            ->groupBy('stok.kode_barang')
            ->get();

        return json_encode($data);
    }

    public function acc_pembelian(Request $request)
    {
        $id = $request->id;
        $status = $request->status;
        $order = Pembelian::findOrFail($id);
        $order->status = $request->status;
        $simpan = $order->save();
        if($request->status==1){
            $this->addNotif(Auth::user()->nip,'Telah Menginput Daftar Pembelian Baru');
        }else{
            $this->addNotif(Auth::user()->nip,'Telah Menolak Daftar Pembelian Baru');
        }
        if ($simpan) {
            Session::flash('success', 'Disable berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Disable gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    public function add_pembelian(Request $request)
    {
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $nomor_surat = IdGenerator::generate(['table' => 'orders', 'field' => 'id_order', 'length' => 15, 'prefix' => 'ORD-' . $year . '-']);
        $pembelian = new Pembelian;
        $pembelian->id_order = $nomor_surat;
        $pembelian->tgl_order = $request->tgl_pesan;
        $pembelian->total = 0;
        $pembelian->diskon_order = 0;
        $pembelian->order_by = $request->pengaju;
        $pembelian->status = 0;
        $pembelian->id_supplier = $request->supplier;
        if (!$pembelian->save()) {
            return redirect()->back()->with('alert-fail', 'Data Pengajuan Gagal Dibuat');
        }
        $totDiskon = 0;
        $totTotal = 0;
        foreach ($request->nama_barang as $idx => $val) {
            $id = IdGenerator::generate(['table' => 'list_order', 'field' => 'id_list_order', 'length' => 12, 'prefix' => 'IOD-']);
            $item = new ListItem;
            $item->id_list_order = $id;
            $item->kode_barang = $request->nama_barang[$idx];
            $item->id_order = $nomor_surat;
            $item->kode_satuan = $request->satuan[$idx];
            $item->harga_beli = $request->harga[$idx];
            $item->diskon = $request->diskon[$idx];
            $item->total = (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx])+ (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx]) *($request->ppn[$idx] / 100);
            $item->jumlah = $request->jumlah[$idx];
            $item->ppn = $request->ppn[$idx];
            $totDiskon += ($request->harga[$idx] * ($request->diskon[$idx] / 100))* $request->jumlah[$idx];
            $totTotal += (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx])+ (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx]) *($request->ppn[$idx] / 100) ;
            $item->save();
        }

        $pembelian = Pembelian::where('id_order', '=', $nomor_surat)->firstOrFail();
        $pembelian->total = $totTotal;
        $pembelian->diskon_order = $totDiskon;
        $pembelian->save();
        $this->addNotif(Auth::user()->nip,'Telah Menginput Daftar Pembelian Baru');
        return redirect('/pembelian')->with('alert-success', 'Data Pengajuan Berhasil Dibuat');
    }

    function list_pembelian(Request $request)
    {
        $res['data'] = Pembelian::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_pembelian(Request $request)
    {
        $id = decrypt($request->id);
        $order = Pembelian::join('staf', 'orders.order_by', '=', 'staf.nip')
            ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'supplier.nama_supplier', 'staf.nama_staf')
            ->get();

        $data = ListItem::whereIn('id_order', function ($query) use ($id) {
            $query->select('id_order')
                ->from(with(new Pembelian)->getTable())
                ->where('id', '=', $id);
        })
            ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
            ->join('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
            ->select('list_order.*', 'satuan.satuan','barang.nama_barang')
            ->get();
        $res['order'] = $order;
        $res['data'] = $data;
        $res['supplier'] = Supplier::orderby('created_at', 'DESC')
            ->get();
        $res['satuan'] = Satuan::orderby('created_at', 'DESC')
            ->get();
            $res['obat']= Obat::where('kode_barang','!=',null)->get();
        return view('pembelian/edit-pembelian', $res);
    }

    function update_pembelian(Request $request)
    {
         $pembelian =  Pembelian::where('id_order', '=', $request->nomor_surat)->firstOrFail();
        $pembelian->id_supplier = $request->supplier;
        if (!$pembelian->save()) {
            return redirect()->back()->with('alert-fail', 'Data Pengajuan Gagal Dibuat');
        }
        $totDiskon = 0;
        $totTotal = 0;
        foreach ($request->nama_barang as $idx => $val) {
            if($request->id_list_order[$idx]==null || $request->id_list_order[$idx]=="" ){
                $id = IdGenerator::generate(['table' => 'list_order', 'field' => 'id_list_order', 'length' => 12, 'prefix' => 'IOD-']);
                $item = new ListItem;
                $item->id_list_order= $id ;
                $item->id_order= $request->nomor_surat;
            }else{
                $item = ListItem::where('id_list_order', '=', $request->id_list_order[$idx])->first();
            }
            $item->kode_barang = $request->nama_barang[$idx];
            $item->kode_satuan = $request->satuan[$idx];
            $item->harga_beli = $request->harga[$idx];
            $item->diskon = $request->diskon[$idx];
            //dd($request);
            $item->total = (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx])+ (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx]) *($request->ppn[$idx] / 100);
            $item->jumlah = $request->jumlah[$idx];
            $item->ppn = $request->ppn[$idx];
            $totDiskon += ($request->harga[$idx] * ($request->diskon[$idx] / 100))* $request->jumlah[$idx];
            $totTotal += (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx])+ (($request->harga[$idx] - ($request->harga[$idx] * ($request->diskon[$idx] / 100))) * $request->jumlah[$idx]) *($request->ppn[$idx] / 100);
            $item->save();
        }
        $pembelian = Pembelian::where('id_order', '=', $request->nomor_surat)->firstOrFail();
        $pembelian->total = $totTotal;
        $pembelian->diskon_order = $totDiskon;
        $pembelian->save();

        if ($pembelian->save()) {
            Session::flash('alert-success', 'Update berhasil! Silahkan periksa data terbaru');
            return redirect()->back();
        } else {
            Session::flash('alert-fail', ['' => 'Update gagal! Silahkan ulangi kembali']);
            return redirect()->back();
        }
    }

    function delete_pembelian(Request $request)
    {
        $list = Pembelian::findOrFail($request->id);
        $simpan = $list->delete();
        if ($simpan) {
            Session::flash('success', 'Hapus berhasil! Silahkan periksa data terbaru');
            return redirect()->route('data-list');
        } else {
            Session::flash('errors', ['' => 'Hapus gagal! Silahkan ulangi kembali']);
            return redirect()->route('data-list');
        }
    }

    public function export_excel(Request $request)
    {
        return (new ListItemExport('ORD-2021-001'))->download('invoices.xlsx');
    }

    public function cetak_pdf(Request $request)
    {
        $id = decrypt($request->input('id'));
        $data = ListItem::whereIn('id_order', function ($query) use ($id) {
            $query->select('id_order')
                ->from(with(new Pembelian)->getTable())
                ->where('id', '=', $id);
        })
            ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
            ->leftjoin('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
            ->select('list_order.*', 'satuan.satuan','barang.nama_barang')
            ->get();

        $res['data'] = $data;
        $order = Pembelian::join('staf', 'orders.order_by', '=', 'staf.nip')
            ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'supplier.nama_supplier', 'staf.nama_staf')
            ->get();

        $res['order'] = $order;
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');

        $pdf = PDF::loadview('pembelian/export_pdf', $res);
        return $pdf->download('purchase-order-'.$date.'-pdf');
    }

    public function cetak_pdfs(Request $request)
    {
        $id = '1';
        $data = ListItem::whereIn('id_order', function ($query) use ($id) {
            $query->select('id_order')
                ->from(with(new Pembelian)->getTable())
                ->where('id', '=', $id);
        })
            ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
            ->select('list_order.*', 'satuan.satuan')
            ->get();

        $res['data'] = $data;
        $order = Pembelian::join('staf', 'orders.order_by', '=', 'staf.nip')
            ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
            ->where('orders.id', '=', $id)
            ->select('orders.*', 'supplier.nama_supplier', 'staf.nama_staf')
            ->get();

        $res['order'] = $order;

        return view('pembelian/export_pdf', $res);
    }

    function detail_barang_pembelian(Request $request)
    {
        $pembelian = ListItem::where('id_list_order', $request->id)
            ->firstOrFail();

        return json_encode($pembelian);
    }

    function retur_barang_pembelian(Request $request){
   
        if(!isset($request->check_retur)||count($request->check_retur)<1){
            return false;
        }else{
            $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
            $id = IdGenerator::generate(['table' => 'retur_pembelian', 'field' => 'id_retur_beli', 'length' => 15, 'prefix' => 'RTR-' . $year . '-']);
            foreach ($request->jml_retur as $idx => $val) {
                if($val!=0){
                    DB::beginTransaction();   
                    try { 
                    $retur=new ReturPembelian;
                    $retur->id_retur_beli=$id;
                    $retur->tgl_retur=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                    $retur->id_list_order=$request->id_list_order[$idx];
                    $retur->deskripsi=$request->deskripsi_retur[$idx];
                    $retur->status=0;
                    $retur->jml_retur=$request->jml_retur[$idx];
                    $retur->save();
    
                    $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
                    $kode_brg=ListItem::where('id_list_order','=',$request->id_list_order[$idx])->select('kode_barang')->get();
                  //  dd($kode_brg[0]->kode_barang);
                    $data = Stok::leftJoin(DB::raw('(SELECT
                    t.kode_barang,
                    min(t.sisa) as sisa
                       FROM
                    ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
                    INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
                    AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS history_barang'),
                   'history_barang.kode_barang', '=', 'stok.kode_barang')
                        ->where('stok.kode_barang', '=',$kode_brg[0]->kode_barang)
                        ->select('stok.stock_id', 'stok.jml_akumulasi',DB::raw('COALESCE(COALESCE(history_barang.sisa, stok.jml_masuk ),0) AS sisa'))
                        // ->orderBy('history_barang.created_at', 'desc')
                        // ->orderBy('history_barang.sisa', 'asc')
                        ->take(1)
                        ->get();
    
                     $sisa = $data[0]->sisa==0||$data[0]->sisa==null? $data[0]->jml_akumulasi:$data[0]->sisa;
    
                    $history = new HistoryBarang;
                    $history->id_history=$id_history;
                    $history->kode_barang=$kode_brg[0]->kode_barang;
                    $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                    $history->jml_keluar=$request->jml_retur[$idx];
                    $history->jenis_history='retur_beli';
                    $history->id_referensi=$id;
                    $history->sisa=$sisa -$request->jml_retur[$idx];
                    $history->pic=Auth::user()->nip;
                    $history->save();
                    DB::commit();
                    }catch (Exception $e) {     
                        DB::rollback();
                      }
                }
            }
            return true;
        }
    }

    public function cetak_pdf_retur(Request $request)
    {
        $id = decrypt($request->input('id'));
        $data=ReturPembelian::leftjoin('list_order','list_order.id_list_order','=','retur_pembelian.id_list_order')
        ->leftjoin('barang','list_order.kode_barang','=','barang.kode_barang')
        ->leftjoin('orders', 'orders.id_order', '=', 'list_order.id_order')
        ->join('satuan', 'list_order.kode_satuan', '=', 'satuan.kode_satuan')
        ->join('stok', 'list_order.kode_barang', '=', 'stok.kode_barang')
        ->where('retur_pembelian.id_retur_beli',$id)
        ->select('retur_pembelian.*','satuan.satuan','list_order.jumlah','list_order.diskon','list_order.harga_beli','list_order.total','barang.nama_barang','stok.tgl_exp')
        ->get();

        $res['data'] = $data;
        $detail=ReturPembelian::leftjoin('list_order','list_order.id_list_order','=','retur_pembelian.id_list_order')
        ->leftjoin('barang','list_order.kode_barang','=','barang.kode_barang')
        ->leftjoin('orders', 'orders.id_order', '=', 'list_order.id_order')
        ->join('supplier', 'orders.id_supplier', '=', 'supplier.id_supplier')
        ->where('retur_pembelian.id_retur_beli',$id)
        ->select('retur_pembelian.*','barang.nama_barang', 'supplier.nama_supplier', 'supplier.alamat')
        ->get();

        $res['detail'] = $detail;
        $date= \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        //return view('pembelian/export-retur-pdf', $res);
        $pdf = PDF::loadview('pembelian/export-retur-pdf', $res);
        return $pdf->download('retur-order-'.$date.'-pdf');
    }

    public function delete_item_pembelian(Request $request){
        $item = ListItem::where('id_list_order',$request->id);
        $simpan = $item->delete();
        if ($simpan) {
            Session::flash('success', 'Hapus berhasil! Silahkan periksa data terbaru');
            return 'success';
        } else {
            Session::flash('errors', ['' => 'Hapus gagal! Silahkan ulangi kembali']);
            return 'error';
        }
    }
}
