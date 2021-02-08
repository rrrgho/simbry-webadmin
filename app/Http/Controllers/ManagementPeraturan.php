<?php

namespace App\Http\Controllers;
use App\Models\RuleOrder;
use Illuminate\Http\Request;

class ManagementPeraturan extends Controller
{
    public function index(){
        $data = RuleOrder::where('deleted_at',null)->get();
        return view('management_peraturan.index', compact('data'));
    }
    public function edit(Request $request){
        $data = RuleOrder::find($request->id);
        $data->limit = $request->limit;
        if($data->save())
            return redirect(url('manajemen-peraturan/peraturan'))->with('success','Berhasil mengubah data Edit Limit ');
        return redirect(url('manajemen-peraturan/'.$request->id.'/peraturan'))->with('failed','Gagal mengubah data Edit Limit');

    }
}
