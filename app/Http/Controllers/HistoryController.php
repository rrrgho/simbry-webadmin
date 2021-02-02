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
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->make(true);
    }
    public function filter(Request $request){
        
    }
        
}
