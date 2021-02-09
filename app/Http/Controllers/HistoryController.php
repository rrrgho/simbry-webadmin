<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\History;
use Carbon\Carbon;
use DataTables;
use Illuminate\Contracts\Session\Session;


class HistoryController extends Controller
{
    public function orders(){
        return view('history.index');
    }
    public function historyDatatable(){
        
        $data = History::where('deleted_at',null)->get();
        
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('status', function($data){
            if($data['Success'] != null)        
                return view ('history.success');
            else{
                $data['pending'] != null;
                return view ('history.pending');
            }
        })
        ->addColumn('start_date', function($data){
            return Carbon::parse($data['start_date'])->format('D d, y');
        })
        ->addColumn('end_date', function($data){
            return Carbon::parse($data['end_date'])->format('D d, y');
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->make(true);
    }
    public function filter(Request $request){
        
        if(!empty($request->start_date))
            {
                //Jika tanggal awal(from_date) hingga tanggal akhir(to_date) adalah sama maka
                if($request->from_date === $request->to_date){
                    //kita filter tanggalnya sesuai dengan request from_date
                    $data = History::whereDate('created_at','=', $request->start_date)->get();
                }
                else{
                    //kita filter dari tanggal awal ke akhir
                    $data = History::whereBetween('created_at', array($request->start_date, $request->end_date))->get();
                }                
            }
    }
        
}
