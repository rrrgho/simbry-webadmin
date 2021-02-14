<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BooksOrder;
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

    public function history(){
        $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','FINISHED']
        ])->get();
        return view('management-peminjaman.history_peminjaman',compact('data'));
    }

}
