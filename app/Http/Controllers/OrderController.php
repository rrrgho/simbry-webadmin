<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\BooksOrder;
use Illuminate\Http\Request;

// Call Model
use App\Models\User;
use App\Models\History;
use DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $book = Books::where('deleted_at',null)->get();
        return view('layouts.page_templates.auth', compact('book'));
        // return response()->json($book);
        // return $request->all();
    }
    public function Order(Request $request)
    {
        $user = User::where('deleted_at',null)->get();
        $book = Books::where('deleted_at',null)->get();
        if(!$request->all())
            return view('peminjaman-masuk.addOder', compact('user','book'));
        else{
            DB::transaction(function () use ($book, $request){
                DB::table('book')->update(['ready' => 0]);
                DB::table('book')->insert(['borrowed' => + 1]);
                $insert = $request->validate([
                    'book_id' => 'required'
                ]);
                $insert = BooksOrder::create([
                    'user_id' => $request->user_id,
                    'book_id' =>  $request->book_id,
                    'status' => 'APPROVED',
                    'start_date' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
                    'end_date' => Carbon::now('Asia/Jakarta')->addDays(3)->toDateTimeString()
                ]);
                if($insert->save());
                    return redirect(route('main-peminjaman-siswa'))->with('success', 'Success stored new province data');
                return redirect(route('main-peminjaman-siswa'))->with('failed', 'failed stored new province data');
            });
        }
    }
    public function peminjaman(){
        $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','PENDING'],
        ])->get();
        return view('peminjaman-masuk.index', compact('data'));
    }
    public function approved(Request $request){
        $userType =  $request->user_type_id;
        if ($userType == 1) {
            $endDate = Carbon::now('Asia/Jakarta')->addDays(2)->toDateTimeString();
            
        } else {
            $endDate = Carbon::now('Asia/Jakarta')->addDays(3)->toDateTimeString();
        }
        $data = BooksOrder::find($request->id);
        dd($data);
        // return $data;
        $data->status = $request->status;
        $data->start_date = Carbon::now('Asia/Jakarta')->toDateTimeString();
        $data->end_date = $endDate;
        if($data->save())
            return redirect(url('peminjaman-masuk/peminjaman-masuk'))->with('success','Berhasil mengubah data Edit Limit ');
        return redirect(url('peminjaman-masuk/'.$request->id.'/peminjaman-masuk'))->with('failed','Gagal mengubah data Edit Limit');
    }
}
