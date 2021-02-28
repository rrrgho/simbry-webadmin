<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use App\Models\BooksOrder;
use App\Models\ClassModel;
use DataTables;

use Carbon\Carbon;

class ManagementPeminjaman extends Controller
{
    public function masuk(){
        $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','APPROVED'],
            ['end_date','>=',Carbon::now('Asia/Jakarta')]
        ])->get();
        return view('management-peminjaman.peminjaman_berjalan', compact('data'));
    }
    
    public function expired(){
        $data = $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','APPROVED'],
            ['end_date','<',Carbon::now('Asia/Jakarta')]
        ])->get();
        return view('management-peminjaman.peminjaman_expired', compact('data'));
    }
    public function finished(Request $request)
    {
        $data = BooksOrder::find($request->id);
        Books::find($data->book_id)->update(['ready' => 1]);
        $data->status = $request->status;
        if($data->save())
            return redirect(url('management-peminjaman/expired'))->with('success','Siswa & Guru Sudah Memulangkan Buku ');
        return redirect(url('management-peminjaman/'.$request->id.'/expired'))->with('failed','Siswa & Guru gagal memulangkan buku');
    }
    public function history(){
        $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','FINISHED']
        ])->get();
        return view('management-peminjaman.history_peminjaman',compact('data'));
    }

}
