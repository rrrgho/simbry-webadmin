<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BooksOrder;
use App\Models\User;
use Datatables;

class ManagementPeminjaman extends Controller
{
    public function masuk(){
        $data = BooksOrder::where('deleted_at',null)->get();
        return view('management-peminjaman.peminjaman_berjalan', compact('data'));
    }
    public function expired(){
        $data = BooksOrder::where('deleted_at',null)->get();
        return view('management-peminjaman.peminjaman_expired', compact('data'));
    }

    public function history(){
        $data = BooksOrder::where('deleted_at',null)->get();
        return view('management-peminjaman.history_peminjaman',compact('data'));
    }

}
