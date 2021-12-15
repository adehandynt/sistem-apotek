<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Auth;
use App\Models\notification;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use View;
use session;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->authCheck();
    }
    
    public function authCheck()
    {  
        try{
          
                if(Auth::user()==null)
                return redirect()->route('logout');
        
        }catch (Throwable $e) {
            return redirect()->route('logout');
        }
    }

    public function addNotif($from="",$perihal=""){
        $notif=new notification;
        $notif->id_notif=IdGenerator::generate(['table' => 'notification','field'=>'id_notif', 'length' =>15, 'prefix' =>'NTF-']);;
        $notif->from=$from;
        $notif->perihal=$perihal;
        $notif->tgl_notif=\Carbon\Carbon::now()->timezone('Asia/Jakarta');
        $notif->status=0;
        $notif->save();
    }
    public function getNotif($nip){
        $data = notification::where('from','!=',$nip)
        ->where('status','=',0)
        ->orderBy('id','desc')
        ->get()->take(5);
        return view('main/header')->with('notif', $data);
    }
}
