<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Stok;
use App\Models\Order;
use App\Models\Satuan;
use App\Models\Tipe;
use App\Models\Obat;
use App\Models\ListItem;
use App\Models\Pembelian;
use App\Models\HistoryBarang;
use App\Models\StockOpname;
use App\Models\ReturPembelian;
use App\Models\ListOpname;
use App\Models\Margin;
use Validator;
use Hash;
use Session;
use DB;
use Auth;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class StockController extends Controller
{
    public function v_stock()
    {
        $res['data'] = Order::
        where('status','=','1')
        ->where(function ($query) {
            $query->where('status_pembelian','=','0')
                ->orWhere('status_pembelian','=',null);
        })
        ->get();
        $res['data_retur'] = ReturPembelian::
        where('status','=','0')
        ->groupBy('id_retur_beli')
        ->get();
        $res['satuan'] = Satuan::get();
        $res['tipe'] = Tipe::get();
        $res['margin'] = Margin::get();
        return view('stock/stock',$res);
    }

    public function v_stock_opname()
    {
        $tanggal=\Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('Y-m-d');
        $tanggal = substr($tanggal,0,7);
        $tanggal2=\Carbon\Carbon::now()->subDays(27, 'day')->timezone('Asia/Jakarta')->format('Y-m-d');
        $tanggal2 = substr($tanggal2,0,7);
        $res['data'] = StockOpname::get();
        $res['satuan'] = Satuan::get();
        $res['tipe'] = Tipe::get();
        $res['list_produk'] = Obat::join(DB::raw('(SELECT
        t.kode_barang,
        min( t.sisa ) AS sisa 
    FROM
        ( SELECT kode_barang, jenis_history, min( created_at ) AS MinTime, created_at FROM history_barang WHERE
        jenis_history = "barang_masuk"  GROUP BY kode_barang ) r
        INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MinTime 
    GROUP BY
        t.kode_barang) AS history_barang'),
       'history_barang.kode_barang', '=', 'barang.kode_barang')
       ->join(DB::raw('(SELECT
       t.kode_barang,
       min( t.sisa ) AS sisa_tercatat
   FROM
       ( SELECT kode_barang, jenis_history, max( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
       INNER JOIN history_barang t ON t.kode_barang = r.kode_barang 
       AND t.created_at = r.MaxTime 
   GROUP BY
       t.kode_barang) AS history_barang_catat'),
      'history_barang_catat.kode_barang', '=', 'barang.kode_barang')
       ->leftjoin(DB::raw('(SELECT
        t.*
           FROM
        ( SELECT *, MAX( created_at ) AS MaxTime FROM list_opname GROUP BY kode_barang ) r
        INNER JOIN list_opname t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS list_opname'),
      'list_opname.kode_barang', '=', 'barang.kode_barang')
      ->leftjoin(DB::raw('(SELECT
      t.kode_barang,
      t.totalKeluar 
  FROM
      ( SELECT kode_barang, max( created_at ) AS MaxTime, created_at FROM list_opname GROUP BY kode_barang ) r
      INNER JOIN (
      SELECT
          list_opname.*,
          sum( jml_keluar ) AS totalKeluar ,
           history_barang.tgl_keluar 
      FROM
          history_barang
          JOIN (
          SELECT
              x.* 
          FROM
              ( SELECT *, MAX( created_at ) AS MaxTime FROM list_opname GROUP BY kode_barang ) y
              INNER JOIN list_opname x ON x.kode_barang = y.kode_barang 
              AND x.created_at = y.MaxTime 
          GROUP BY
              x.kode_barang 
          ) list_opname ON history_barang.kode_barang = list_opname.kode_barang 
      WHERE
           history_barang.tgl_keluar >= list_opname.created_at  
      ) t ON t.kode_barang = r.kode_barang 
      AND t.created_at = r.MaxTime 
  GROUP BY
      t.kode_barang) AS history_barang_keluar'),
     'history_barang_keluar.kode_barang', '=', 'barang.kode_barang')
     ->leftjoin(DB::raw('(SELECT
      t.kode_barang,
      t.totalMasuk 
  FROM
      ( SELECT kode_barang, max( created_at ) AS MaxTime, created_at FROM list_opname GROUP BY kode_barang ) r
      INNER JOIN (
      SELECT
          list_opname.*,
          sum( jml_masuk ) AS totalMasuk ,
           history_barang.tgl_masuk
      FROM
          history_barang
          JOIN (
          SELECT
              x.* 
          FROM
              ( SELECT *, MAX( created_at ) AS MaxTime FROM list_opname GROUP BY kode_barang ) y
              INNER JOIN list_opname x ON x.kode_barang = y.kode_barang 
              AND x.created_at = y.MaxTime 
          GROUP BY
              x.kode_barang 
          ) list_opname ON history_barang.kode_barang = list_opname.kode_barang 
      WHERE
           history_barang.tgl_masuk >= list_opname.created_at  
      ) t ON t.kode_barang = r.kode_barang 
      AND t.created_at = r.MaxTime 
  GROUP BY
      t.kode_barang) AS history_barang_masuk'),
     'history_barang_masuk.kode_barang', '=', 'barang.kode_barang')
     ->leftjoin(DB::raw('(SELECT
     *,
     sum(jml_masuk) as jml_masuk_default,
     sum(jml_keluar) as jml_keluar_default
        FROM history_barang where created_at LIKE "'.$tanggal2.'%"group by kode_barang) AS history_barang_default'),
   'history_barang_default.kode_barang', '=', 'barang.kode_barang')
        ->select('list_opname.*','barang.*','history_barang_catat.sisa_tercatat','history_barang.sisa',
        DB::raw('coalesce(list_opname.saldo_akhir,0) as saldo_awal'),
        DB::raw('coalesce(history_barang_masuk.totalMasuk,history_barang_default.jml_masuk_default,0) as totalMasuk'),
        DB::raw('coalesce(history_barang_keluar.totalKeluar,history_barang_default.jml_keluar_default,0) as totalKeluar'))
        ->where(function ($query) use ($tanggal) {
            $query->whereNull('list_opname.id_list_opname')
            ->orWhere('list_opname.created_at','NOT LIKE',$tanggal."%");
        })
        ->orderBy('barang.nama_barang','asc')
        ->get();
        return view('stock/stock-opname',$res);
    }
    public function v_list_stock_opname()
    {
        $data = StockOpname::get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = ' <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#detail-modal" data-id="' . $data[$i]->id_opname . '"
            class="btn-detail action-icon"> <i
                class="mdi mdi-eye"></i></a>';
        }
        return json_encode($data);
    }

    public function get_list_opname(Request $request)
    {
        $data = StockOpname::join('list_opname','stock_opname.id_opname','=','list_opname.id_opname')
        ->join('barang','barang.kode_barang','=','list_opname.kode_barang')
        ->where('stock_opname.id_opname',$request->id)
        ->get();
        return json_encode($data);
    }

    public function v_list_stock()
    {
        $data = Order::Join('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->Join('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
        ->join(DB::raw('(SELECT
        t.*
        FROM
        ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM stok GROUP BY kode_barang ) r
        INNER JOIN stok t ON t.kode_barang = r.kode_barang
        AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS stok'),
        'stok.kode_barang', '=', 'barang.kode_barang')
        ->join(DB::raw('(SELECT
        t.kode_barang,t.id_history,
        min(t.sisa) as sisa
        FROM
        ( SELECT kode_barang, MAX( created_at ) AS MaxTime, created_at FROM history_barang GROUP BY kode_barang ) r
        INNER JOIN history_barang t ON t.kode_barang = r.kode_barang
        AND t.created_at = r.MaxTime GROUP BY t.kode_barang) AS history_barang'),
        'history_barang.kode_barang', '=', 'barang.kode_barang')
        // ->leftJoin(DB::raw('(SELECT * FROM barang_keluar order by created_at desc limit 1) AS barang_keluar'),
        // 'barang_keluar.stock_id', '=', 'stok.stock_id')
        ->select('stok.*','barang.*','list_order.*',DB::raw('coalesce(history_barang.sisa,jml_akumulasi,jml_masuk) as
        sisa'),'history_barang.id_history')
        ->groupBy('barang.kode_barang')
        ->get();
        // dd($data[0]);
        //        return view('data-master/tipe', $res);
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = ' <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#detail-modal" data-id="' . $data[$i]->kode_barang . '"
            class="btn-detail action-icon"> <i
                class="mdi mdi-eye"></i></a><a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-stock-modal" data-id="' . $data[$i]->id_history . '"
                data-nama="' . $data[$i]->nama_barang . '" data-stock="' . $data[$i]->sisa . '"
                class="btn-edit-stock action-icon"> <i
                    class="mdi mdi-square-edit-outline"></i></a>';
        }
        return json_encode($data);
    }

    public function getOrderID(Request $request){
        $data = Order::Join('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->leftJoin('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
        ->where('orders.id_order','=',$request->id)
        ->where(function ($query) {
            $query->whereNull('list_order.status_terima')
                ->orWhere('list_order.status_terima','=',"");
        })
        ->select('barang.*','list_order.*')->get();

        $tanggal=\Carbon\Carbon::now()->add(730, 'day')->timezone('Asia/Jakarta')->format('Y-m-d');
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->jml_diterimas = '<input type="number" class="form-control numeric_form" name="jml_diterima[]" value="0" required/>';
            $data[$i]->id_list_orders ='<input type="hidden" class="form-control" name="id_list_order[]" value="'.$data[$i]->id_list_order.'" required/>';
            $data[$i]->exps ='<input type="date" class="form-control" name="exp[]" value="'.$tanggal.'"/>';
            $data[$i]->status_receives ='<input type="hidden" class="form-control" name="id_list_order[]" value="'.$data[$i]->id_list_order.'" required/>
            <select class="form-control" id="status_receive" name="status_receive[]" style="width:150px" required>
                    <option value="1">Full</option>
                    <option value="0" selected>Pending</option>
                    <option value="2">Cancel</option>
                </select>';
            $data[$i]->deskripsis ='<input type="text" class="form-control" name="deskripsi[]" value="-" style="width:200px" required/>';
            $data[$i]->action = '<a href="javascript:void(0);" data-id="' . $data[$i]->id_list_order . '"
            class="btn btn-success btn-choose action-icon" style="color:white;font-size:12px;"> <i class="mdi mdi-shield-check"></i> Pilih</a>';
        }
        return json_encode($data);
    }

    public function getReturID(Request $request){
        //dd($request->id);
        $data = Order::Join('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->leftJoin('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
        ->Join('retur_pembelian', 'retur_pembelian.id_list_order', '=', 'list_order.id_list_order')
        ->where('retur_pembelian.id_retur_beli','=',$request->id)
        ->select('barang.*','list_order.*','retur_pembelian.jml_retur')->get();
        $tanggal=\Carbon\Carbon::now()->add(730, 'day')->timezone('Asia/Jakarta')->format('Y-m-d');
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->jml_diterimas = '<input type="number" class="form-control numeric_form" name="jml_diterima[]" value="0" required/>';
            $data[$i]->id_list_orders ='<input type="hidden" class="form-control" name="id_list_order[]" value="'.$data[$i]->id_list_order.'" required/>';
            $data[$i]->exps ='<input type="date" class="form-control" name="exp[]" value="'.$tanggal.'"/>';
            $data[$i]->status_receives ='<input type="hidden" class="form-control" name="id_list_order[]" value="'.$data[$i]->id_list_order.'" required/>
            <select class="form-control" id="status_receive" name="status_receive[]" style="width:150px" required>
                    <option value="1">Full</option>
                    <option value="0" selected>Pending</option>
                    <option value="2">Cancel</option>
                </select>';
            $data[$i]->deskripsis ='<input type="text" class="form-control" name="deskripsi[]" value="-" style="width:200px" required/>';
            $data[$i]->action = '<a href="javascript:void(0);" data-id="' . $data[$i]->id_list_order . '"
            class="btn btn-success btn-choose action-icon" style="color:white;font-size:12px;"> <i class="mdi mdi-shield-check"></i> Pilih</a>';
        }
        return json_encode($data);
    }

    public function detail_list(Request $request){
        if($request->date){
            $data = Order::RightJoin('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->RightJoin('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
        ->RightJoin('stok', 'stok.kode_barang', '=', 'barang.kode_barang')
        ->leftJoin('barang_keluar', 'barang_keluar.stock_id', '=', 'stok.stock_id')
        ->select('stok.*','barang.*','list_order.*',DB::raw('COALESCE(barang_keluar.sisa, 0 ) AS sisa'),'barang_keluar.*')
        ->where('barang.kode_barang','=',$request->id)
        ->where('barang_keluar.created_at', 'like', $request->date.'%')
        ->get();
        $data =HistoryBarang::RightJoin('barang', 'history_barang.kode_barang', '=', 'barang.kode_barang')
        // ->Join('orders', 'list_order.id_order', '=', 'orders.id_order')
        // ->RightJoin('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->select('history_barang.*','barang.*')
        ->where('barang.kode_barang','=',$request->id)
        ->where('history_barang.created_at', 'like', $request->date.'%')
        ->orderBy('history_barang.id','DESC')
        ->get();
        }else{
            $data = Order::RightJoin('list_order', 'orders.id_order', '=', 'list_order.id_order')
            ->RightJoin('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
            ->RightJoin('stok', 'stok.kode_barang', '=', 'barang.kode_barang')
            ->leftJoin('barang_keluar', 'barang_keluar.stock_id', '=', 'stok.stock_id')
            ->select('stok.*','barang.*','list_order.*',DB::raw('COALESCE(barang_keluar.sisa, 0 ) AS sisa'),'barang_keluar.*')
            ->where('barang.kode_barang','=',$request->id)
            ->get();
            $data =HistoryBarang::RightJoin('barang', 'history_barang.kode_barang', '=', 'barang.kode_barang')
        //     ->Join('orders', 'list_order.id_order', '=', 'orders.id_order')
        // ->RightJoin('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->select('history_barang.*','barang.*')
        ->where('barang.kode_barang','=',$request->id)
        ->orderBy('history_barang.id','DESC')
        ->get();
        }
        
        return json_encode($data);
    }

    public function add_stock(Request $request)
    {
      
        if ($request->input('exp') == null) {
            return false;
        }
        $data = Order::Join('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->Join('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
        // ->leftJoin('stok', 'stok.kode_barang', '=', 'barang.kode_barang')
        ->where('orders.id_order','=',$request->input('order_id'))
        ->select('barang.*','list_order.*')->get(); 

        DB::beginTransaction();   
        try { 
        $pembelian = Pembelian::where('id_order', '=', $request->input('order_id'))->firstOrFail();
        $pembelian->grn = $request->grn;
        $pembelian->no_faktur =  $request->faktur;
        $pembelian->supplier_do =  $request->do;
        $pembelian->status_pembelian = 1;
        $pembelian->penerima = Auth::user()->nip;
        $pembelian->save();
 
        // $idx=0;
        foreach($data as $val){
            $idx= array_search($val->id_list_order,$request->id_list_order);
            $id_stok = IdGenerator::generate(['table' => 'stok','field'=>'stock_id', 'length' => 9, 'prefix' =>'STK-']);
            $sisa = HistoryBarang::select('sisa')->orderby('created_at','desc')->where('kode_barang','=',$val->kode_barang)->get()->first();
            $stok = new Stok;
            $stok->stock_id=$id_stok;
            $stok->kode_barang=$val->kode_barang;
            $stok->tgl_masuk=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
            $stok->tgl_exp= $request->exp[$idx];
            $stok->jml_masuk= $request->jml_diterima[$idx];
            $stok->jml_akumulasi= ($sisa==null?0:$sisa->sisa) + $request->jml_diterima[$idx];
            $stok->id_order=$val->id_order;
            $stok->save();

            $this->addNotif(Auth::user()->nip,'Barang #'.$val->kode_barang.' telah diterima');

            $item = ListItem::where('id_list_order', '=',  $request->id_list_order[$idx])->firstOrFail();
            $item -> jumlah_diterima=$request->jml_diterima[$idx];
            $item -> status_terima=$request->status_receive[$idx];
            $item -> deskripsi=$request->deskripsi[$idx];
            $item->save();

            $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
            $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
            $history = new HistoryBarang;
            $history->id_history=$id_history;
            $history->kode_barang=$val->kode_barang;
            $history->tgl_masuk=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
            $history->jml_masuk=$request->jml_diterima[$idx];
            $history->sisa=($sisa==null?0:$sisa->sisa)+$request->jml_diterima[$idx];
            $history->jenis_history='barang_masuk';
            $history->id_referensi=$val->id_order;
            $history->pic=Auth::user()->nip;
            $history->save();
            
            // $idx++;
        }

        // $pembelian = Pembelian::where('id_order', '=', $request->input('order_id'))->firstOrFail();
        // $pembelian->grn = $request->grn;
        // $pembelian->no_faktur =  $request->faktur;
        // $pembelian->supplier_do =  $request->do;
        // $pembelian->status_pembelian = 1;
        // $pembelian->penerima = Auth::user()->nip;
        // $pembelian->save();
      
        DB::commit();
        return true;
    }catch (Exception $e) {     
        DB::rollback();
      }
    }

    public function add_stock_retur(Request $request)
    {
     
        if ($request->input('exp') == null) {
            return false;
        }
       
        $data = Order::Join('list_order', 'orders.id_order', '=', 'list_order.id_order')
        ->leftJoin('barang', 'list_order.kode_barang', '=', 'barang.kode_barang')
        ->Join('retur_pembelian', 'retur_pembelian.id_list_order', '=', 'list_order.id_list_order')
        ->where('retur_pembelian.id_retur_beli','=',$request->input('retur_id'))
        ->select('barang.*','list_order.*','retur_pembelian.jml_retur')->get(); 

        // $idx=0;
        DB::beginTransaction();   
        try { 
        foreach($data as $val){
            $idx= array_search($val->id_list_order,$request->id_list_order);
            $id_stok = IdGenerator::generate(['table' => 'stok','field'=>'stock_id', 'length' => 9, 'prefix' =>'STK-']);
            $sisa = HistoryBarang::select('sisa')->orderby('created_at','desc')->where('kode_barang','=',$val->kode_barang)->get()->first();
            $stok = new Stok;
            $stok->stock_id=$id_stok;
            $stok->kode_barang=$val->kode_barang;
            $stok->tgl_masuk=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
            $stok->tgl_exp= $request->exp[$idx];
            $stok->jml_masuk= $request->jml_diterima[$idx];
            $stok->jml_akumulasi= ($sisa==null?0:$sisa->sisa) + $request->jml_diterima[$idx];
            $stok->id_order=$val->id_order;
            $stok->save();
         
            $this->addNotif(Auth::user()->nip,'Barang #'.$val->kode_barang.' telah diterima');

            $item = ListItem::where('id_list_order', '=',  $request->id_list_order[$idx])->firstOrFail();
            $item -> jumlah_diterima=$request->jml_diterima[$idx];
            $item -> status_terima=$request->status_receive[$idx];
            $item -> deskripsi=$request->deskripsi[$idx];
            $item->save();

            $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
            $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
            $history = new HistoryBarang;
            $history->id_history=$id_history;
            $history->kode_barang=$val->kode_barang;
            $history->tgl_masuk=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
            $history->jml_masuk=$request->jml_diterima[$idx];
            $history->sisa=($sisa==null?0:$sisa->sisa)+$request->jml_diterima[$idx];
            $history->jenis_history='barang_masuk';
            $history->id_referensi=$request->id_list_order[$idx];
            $history->pic=Auth::user()->nip;
            $history->save();
            
            // $idx++;
        }
      
        DB::commit();
        return true;
    }catch (Exception $e) {     
        DB::rollback();
      }
    }

    function list_stock(Request $request)
    {
        $res['data'] = Stok::orderby('created_at', 'DESC')
            ->get();
        return json_encode($res['data']);
    }

    function edit_stock(Request $request)
    {
        // $satuan = Stok::where('id', $request->id)
        //     ->firstOrFail();
        $stock = HistoryBarang::where('id_history', $request->id_hide)
            ->firstOrFail();
        $stock->sisa = $request->stock_barang;
        //dd($stock);
        if($stock->save()){
            return true;
        }else{
            return false;
        }
        //return json_encode($satuan);
    }

    function update_stock(Request $request)
    {
        $rules = [
            'kode_stock'                 => 'required|string',
            'satuan'              => 'required|string',
            'akronim'              => 'required'
        ];

        $messages = [
            'kode_stock.required'               => 'Kode wajib diisi',
            'satuan.required'              => 'Nama wajib diisi',
            'akronim.required'       => 'Akronim wajib diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return json_encode($validator);
        }

        $satuan = Stok::findOrFail($request->id);
        $satuan->kode_stock = $request->nama;
        $satuan->satuan = $request->satuan;
        $satuan->akronim = $request->akronim;
        $simpan = $satuan->save();

        if ($simpan) {
            Session::flash('success', 'Update berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Update gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    function delete_stock(Request $request)
    {
        $list = Stok::findOrFail($request->id);
        $simpan = $list->delete();
        if ($simpan) {
            Session::flash('success', 'Hapus berhasil! Silahkan periksa data terbaru');
            return true;
        } else {
            Session::flash('errors', ['' => 'Hapus gagal! Silahkan ulangi kembali']);
            return false;
        }
    }

    public function get_stock_produk(Request $request)
    {
        $data = ListItem::where('barang.kode_barang',$request->kode)
        ->leftJoin('barang', 'barang.kode_barang','=','list_order.kode_barang')
        ->get();
        return json_encode($data);
    }

    public function get_grn(){
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'orders','field'=>'grn', 'length' => 15, 'prefix' =>'GRN-'. $year . '-']);
        return json_encode($id);
    }

    public function add_opname(Request $request){
        //dd($request->all());
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        $id = IdGenerator::generate(['table' => 'stock_opname','field'=>'id_opname', 'length' => 15, 'prefix' =>'OPN-'. $year . '-']);
        $date = \Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $opname = new StockOpname;
        $opname->id_opname=$id;
        $opname->tgl_opname=$date;
        $opname->pic=Auth::user()->nip;

        if(!$opname->save()){
            return false;
        }else{
            DB::beginTransaction();   
            try { 
            foreach ($request->input('kode_barang') as $idx => $val) {
            $barang=Obat::Join('set_harga', 'barang.kode_barang', '=', 'set_harga.kode_barang')
            ->Join('harga', 'set_harga.id_harga', '=', 'harga.id_harga')
            ->Join('tipe', 'barang.kode_tipe', '=', 'tipe.kode_tipe')
            ->where('barang.kode_barang',$request->kode_barang[$idx])
            ->orderBy('harga.created_at','desc')
            ->select('harga.harga_jual','tipe.jenis_barang')->first();
            $sisa=HistoryBarang::where('kode_barang',$request->kode_barang[$idx])
            ->orderBy('created_at','desc')->first();
            $id_list = IdGenerator::generate(['table' => 'list_opname','field'=>'id_list_opname', 'length' => 15, 'prefix' =>'LOPN-'. $year . '-']);
            $list=new ListOpname;
            $list->id_list_opname=$id_list;
            $list->id_opname=$id;
            $list->kode_barang=$request->kode_barang[$idx];
            $list->jml_tercatat=$request->jml_tercatat[$idx];
            $list->jml_fisik=$request->jml_tersedia[$idx];
            $list->masuk=$request->masuk[$idx];
            $list->keluar=$request->keluar[$idx];
            $list->hilang=$request->hilang[$idx];
            $list->rusak=$request->rusak[$idx];
            $list->selisih=$request->selisih[$idx];
            $list->saldo_akhir=$request->saldo_akhir[$idx];
            $list->balance=($barang!=null?$barang->harga_jual:0)*($request->rusak[$idx]+$request->hilang[$idx]);
            $list->save();
            if($request->hilang[$idx]!=0){
                $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
                $history = new HistoryBarang;
                $history->id_history=$id_history;
                $history->kode_barang=$request->kode_barang[$idx];
                $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                $history->jml_keluar=$request->hilang[$idx];
                $history->sisa=$sisa->sisa-$request->hilang[$idx];
                if($barang->jenis_barang=='obat'){
                    $history->jenis_history='obat_hilang';
                }else{
                    $history->jenis_history='barang_hilang';
                }
                $history->id_referensi=$id;
                $history->pic=Auth::user()->nip;
                $history->save();
            } if($request->rusak[$idx]!=0){
                $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
                $history = new HistoryBarang;
                $history->id_history=$id_history;
                $history->kode_barang=$request->kode_barang[$idx];
                $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                $history->jml_keluar=$request->rusak[$idx];
                $history->sisa=$sisa->sisa-$request->rusak[$idx];
                if($barang->jenis_barang=='obat'){
                    $history->jenis_history='obat_rusak';
                }else{
                    $history->jenis_history='barang_rusak';
                }
                $history->id_referensi=$id;
                $history->pic=Auth::user()->nip;
                $history->save();
            }
            }
            DB::commit();
            return true;
        }catch (Exception $e) {     
            DB::rollback();
          }
        }
    }

    public function setAsStock(Request $request){
        $data = StockOpname::
        join(DB::raw('(SELECT
        t.*
    FROM
        ( SELECT *, max( created_at ) AS MaxTime FROM list_opname GROUP BY kode_barang ) r
        INNER JOIN list_opname t ON t.kode_barang = r.kode_barang 
        AND t.created_at = r.MaxTime 
    GROUP BY
        t.kode_barang) AS list_opname'),
        'stock_opname.id_opname', '=', 'list_opname.id_opname')
        // ->join('list_opname','stock_opname.id_opname','=','list_opname.id_opname')
        ->join('barang','barang.kode_barang','=','list_opname.kode_barang')
        ->where('list_opname.status_sinkronasi','0')
        ->get();
       // dd($data);
        $year = \Carbon\Carbon::now()->timezone('Asia/Jakarta')->year;
        foreach ($data as $idx => $val) {
            if($val->selisih!=0){
                $id_history = IdGenerator::generate(['table' => 'history_barang','field'=>'id_history', 'length' => 15, 'prefix' =>'HIS-'. $year . '-']);
                $history = new HistoryBarang;
                    $history->id_history=$id_history;
                    $history->kode_barang=$val->kode_barang;
                    if($val->selisih<0){
                    $history->tgl_keluar=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                    $history->jml_keluar=$val->jml_tercatat-$val->jml_fisik;
                    }else{
                    $history->tgl_masuk=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
                    $history->jml_masuk=$val->saldo_akhir-($val->jml_tercatat);
                    }
                    $history->sisa=$val->saldo_akhir;
                    $history->jenis_history='adjustment_stock';
    
                    $history->id_referensi=$val->id_opname;
                    $history->pic=Auth::user()->nip;
                    $history->save();
                    //dd($history);
                   
                    $list = ListOpname::where('id_list_opname',$val->id_list_opname)->first();
                    $list->status_sinkronasi = 1;
                    $list->save();
                    
            }
        }
        return json_encode($data);
    }
}
