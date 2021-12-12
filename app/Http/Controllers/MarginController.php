<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Penjualan;
use App\Models\Obat;
use App\Models\Satuan;
use App\Models\Pembelian;
use App\Models\Harga;
use App\Models\ItemPenjualan;
use App\Models\SetHarga;
use App\Models\Stok;
use App\Models\Supplier;
use App\Models\ListItem;
use App\Models\Staf;
use App\Models\ReturJual;
use App\Models\HistoryBarang;
use App\Models\RekamMedis;
use App\Models\Margin;
use Validator;
use Hash;
use DB;
use PDF;
use Auth;
use Session;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class MarginController extends Controller
{
    public function margin_page(Request $request){
        $res['margin']=Margin::get();
        return view('data-master/margin',$res);
    }

    public function list_margin_page(Request $request){
        $data = Margin::get();
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]->action = ' <a href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#edit-modal" data-id="' . $data[$i]->id . '"
            class="btn-update action-icon"> <i
                class="mdi mdi-pencil-outline"></i></a>';
        }
        return json_encode($data);
    }
    public function add_margin(Request $request){
        $id = IdGenerator::generate(['table' => 'margin','field'=>'id_margin', 'length' => 8, 'prefix' =>'MRG-']);
        $margin=new margin;
        $margin->id_margin=$id;
        $margin->margin_name=$request->margin_name;
        $margin->margin_percentage=$request->margin_percentage;
        $margin->save();
        return true;
    }

    public function update_margin(Request $request){
        $margin = Margin::where('id', $request->id)
        ->firstOrFail();
        $margin->margin_name=$request->margin_name_edit;
        $margin->margin_percentage=$request->margin_percentage_edit;
        $margin->save();
        return true;
    }

    public function edit_margin(Request $request){
        $margin = Margin::where('id', $request->id)
        ->firstOrFail();

         return json_encode($margin);
    }
}
