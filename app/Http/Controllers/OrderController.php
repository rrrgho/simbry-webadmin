<?php

namespace App\Http\Controllers;

use App\Models\BooksOrder;
use Illuminate\Http\Request;

// Call Model
use App\Models\User;
use App\Models\History;
use DataTables;
use Illuminate\Support\Carbon;
class OrderController extends Controller
{
    public function CheckUser(Request $request){
        $user = User::where('user_number', $request->user_number)->first();
        $data['name'] = $user['name'];
        $data['id'] = $user['id'];
        if($user)
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $data], 200);
        return response()->json(['error' => true, 'message' => 'tidak ada data'], 200);
    }

    public function NewOrder(Request $request){
        return $request->all();
    }
    public function peminjaman(){
        $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','PENDING'],
        ])->get();
        return view('peminjaman-masuk.index', compact('data'));
    }
    public function approved(Request $request){
        $data = BooksOrder::find($request->id);
        $data->status = $request->status;
        if($data->save())
            return redirect(url('peminjaman-masuk/peminjaman-masuk'))->with('success','Berhasil mengubah data Edit Limit ');
        return redirect(url('peminjaman-masuk/'.$request->id.'/peminjaman-masuk'))->with('failed','Gagal mengubah data Edit Limit');
    }
}
