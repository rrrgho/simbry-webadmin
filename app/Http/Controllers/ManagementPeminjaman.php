<?php

namespace App\Http\Controllers;

use App\Models\Books;
use Illuminate\Http\Request;
use App\Models\BooksOrder;
use App\Models\ClassModel;
use App\Models\LogExtends;
use DataTables;

use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ManagementPeminjaman extends Controller
{
    public function masuk(){
        $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','APPROVED'],
            ['end_date','>=',Carbon::now('Asia/Jakarta')]
        ])->orderBy('created_at','DESC')->get();
        // return $data;
        return view('management-peminjaman.peminjaman_berjalan', compact('data'));
    }

    public function expired(Request $request){
        $data = $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','APPROVED'],
            ['end_date','<',Carbon::now('Asia/Jakarta')]
        ])->get();
        return view('management-peminjaman.peminjaman_expired', compact('data'));
    }
    public function expiredDatatable()
    {
        $data = $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','APPROVED'],
            ['end_date','<',Carbon::now('Asia/Jakarta')]
        ])->orderBy('created_at','DESC')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('user_id', function($data){
            return $data->user_relation['name'];
        })
        ->addColumn('book_id', function($data){
            return $data->book_relation['name'];
        })
        ->addColumn('start_date', function($data){
            return Carbon::parse($data['start_date'])->format('F d, y');
        })
        ->addColumn('end_date', function($data){
            return Carbon::parse($data['end_date'])->format('F d, y');
        })
        ->addColumn('action', function($data){
            $dataEnd = Carbon::parse($data['end_date']);
            return '<button class="btn btn-danger p-1 text-white"> '.$dataEnd->diffInDays(Carbon::now('Asia/Jakarta')).' Hari </button>';
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function search(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $data = DB::table('book_order')->select()
            ->where('end_date', '>=', $startDate)
            ->where('end_date','<=',$endDate)
            ->orderBy('end_date', 'DESC')
            ->get();
        dd($data);

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
        ])->orderBy('created_at','DESC')->get();
        return view('management-peminjaman.history_peminjaman', compact('data'));
    }
    public function extends(){
        $data = LogExtends::where([
            ['deleted_at',null],
            ['status',1],
        ])->orderBy('created_at','DESC')->get();
        return view('management-peminjaman.peminjaman_extends', compact('data'));
    }
}
