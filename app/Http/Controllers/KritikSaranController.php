<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;
use App\Models\KritikSaran;

class KritikSaranController extends Controller
{
    public function kritik_saran(){
        return view('kritik-saran.index');
    }
    public function kritik_datatable(){
        $data = KritikSaran::where('deleted_at',null)->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->make(true);
    }
}
