<?php

namespace App\Http\Controllers;

use App\Models\Books;
use App\Models\BooksOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

// Call Model
use App\Models\User;
use App\Models\History;
use App\Models\Late;
use App\Models\LogExtends;
use DataTables;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function searchUser(Request $request){
        $validasi = Validator::make($request->all(),[
            'data_user' => 'required'
        ]);
        if($validasi->fails()){
            return response()->json(['error' => true, 'message' => $validasi->errors()->first()], 200);
        }
        $user = User::where('name', 'like', '%' . $request->data_user . '%')->orderBy('created_at','DESC')->get();
        if($user){
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $user], 200);
        }
        return response()->json(['error' => true, 'message' => 'tidak ada data'], 200);
    }
    public function CheckUser(Request $request){
        $user = User::whereRaw("REPLACE(user_number,'.','') = ?",[$request->user_number])->first();
        // $user = User::where('user_number', $request->user_number)->first();
        if($user){
            $data['name'] = $user['name'];
            $data['id'] = $user['id'];
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $data], 200);
        }
        return response()->json(['error' => true, 'message' => 'tidak ada data'], 200);
    }
    public function CheckBook(Request $request){
        $validasi = Validator::make($request->all(),[
            'data_book' => 'required'
        ]);
        if($validasi->fails()){
            return response()->json(['error' => true, 'message' => $validasi->errors()->first()], 200);
        }
        $book = Books::where('name', 'like', '%' . $request->data_book . '%')->where('ready',1)->orderBy('created_at','DESC')->get();
        if($book){
            return response()->json(['error' => false, 'message' => 'Success', 'data' => $book], 200);
        }
        return response()->json(['error' => true, 'message' => 'tidak ada data'], 200);
    }
    public function pemulangan(Request $request)
    {
        $data = User::has('order')->get();
        $book = Books::has('order')->get();
        return view('pemulangan.index',compact('data','book'));
    }

    public function savePemulangan(Request $request)
    {
        $data = $request->validate([
            'user_number' => ['required'],
            'book_number' => ['required'],
        ]);
        // $user = User::whereRaw("REPLACE(user_number,'.','') = ?",[$data['user_number']])->first();
        $user = User::where('id', $data['user_number'])->first();
        if (!$user) {
            return redirect()->back()->with('success', [
                'status' => false,
                'message' => 'Data User tidak ada'
            ]);
        }
        // $book = Books::whereRaw("REPLACE(book_number,'-','') = ?",[$data['book_number']])->first();
        $book = Books::where('id', $data['book_number'])->first();
        if (!$book) {
            return redirect()->back()->with('success', [
                'status' => false,
                'message' => 'Data buku tidak ada'
            ]);
        }
        $order = BooksOrder::where('user_id', $user->id)->where('book_id', $book->id)->where('status','APPROVED')->first();
        if (!$order) {
            return redirect()->back()->with('success', [
                'status' => false,
                'message' => 'Data peminjaman tidak ada'
            ]);
        }
        try {
            DB::transaction(function () use ($user, $book, $order, $data) {
                    if(Carbon::parse($order->end_date)->lt(now())){
                        Late::create([
                            'user_id' => $user->id,
                            'date' => Carbon::now('Asia/Jakarta')->addDays(3)->toDateTimeString(),
                        ]);
                    }
                    $user->point = $user['point'] + 10;
                    $order->update([
                        'status' => 'FINISHED'
                    ]);
                    $book->update([
                        'ready' => 1
                    ]);
                    $user->save();

            });
        } catch (\Exception $e) {
            return redirect()->back()->with('success', [
                'status' => false,
                'message' => 'Gagal simpan data'
            ]);
        }
        if($user->user_type_id == 2)
        {
            return redirect()->back()->with('success', [
                'status' => true,
                'message' => 'Guru Sudah Memulangkan Buku'
            ]);

        }else{
            return redirect()->back()->with('success', [
                'status' => true,
                'message' => 'Siswa Sudah Memulangkan Buku'
            ]);
        }
    }
    public function getBookByUserId(Request $request)
    {
        $userId = $request->user_id;

        $book = BooksOrder::where('user_id', $userId)->get();

        return response()->json($book);
    }
    public function NewOrder(Request $request){
        // Validasi
        $validated = $request->validate([
            'book_number_order' => ['required'],
            'user_id' => ['required'],
            // 'end_date' => ['required']
        ]);

        $late = Late::where('user_id', $validated['user_id'])->where('date','>', now()->toDateTimeString())->exists();
        if($late){
            return response()->json(['error' => true, 'message' => 'Belum boleh pinjem, Mohon Tunggu'],200);
        }
        // $book_id = Books::select('id')->whereRaw("REPLACE(book_number,'-','') = ?",[$validated['book_number']])->first();
        $book_id = Books::select('id')->where('id',$validated['book_number_order'])->first();
        if (!$book_id) {
            return response()->json(['error' => true, 'message' => 'Book not found!'], 200);
        }
        $userType = User::find($validated['user_id'])->user_type_id;
        $unfinishedOrder = BooksOrder::where('user_id', User::find($validated['user_id'])->id)->where('status', '<>', 'finished')->count();
        if (($userType == 1 && $unfinishedOrder > 1) || ($userType == 2 && $unfinishedOrder > 2))  {
            return response()->json(['error' => true, 'message' => 'Peminjaman siswa sudah melebihi batas'],200);
        }

        $data = Books::find($book_id);
        if (!$data[0]['ready']) {
            return response()->json(['error' => true, 'message' => 'Data not found!'], 200);
        }
        try {
            DB::transaction(function () use ($data, $validated) {
                $data[0]->ready = false;
                $data[0]->borrowed = $data[0]['borrowed'] + 1;
                $userType = User::find($validated['user_id'])->user_type_id;
                if ($userType == 1) {
                    $endDate = Carbon::now('Asia/Jakarta')->addDays(2)->toDateTimeString();

                } else {
                    $endDate = Carbon::now('Asia/Jakarta')->addDays(3)->toDateTimeString();
                }
                BooksOrder::create([
                    'user_id' => User::find($validated['user_id'])->id,
                    'book_id' => $data[0]->id,
                    'status' => 'PENDING',
                    'start_date' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
                    'end_date' => $endDate
                    // 'end_date' => $validated['end_date']
                ]);
                $data[0]->save();
            });
        } catch (\Exception $e) {
            return response()->json(['error' => true, 'message' => $e], 200);
        }
        return response()->json([
            'error' => false, 'message' => 'Permohonam peminjaman sedang diproses oleh Admin, cek sekala berkala status peminjaman anda !'
        ], 200);
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
        // return $data;
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
        // return $data->book_id;
        if($request->status == 'CANCELED')
        {
            Books::where('id',$data->book_id)->update([
                'ready' => 1,
            ]);
            if($data->delete())
                return redirect(url('peminjaman-masuk/peminjaman-masuk'))->with('success','Admin membatalkan peminjaman siswa');
        }else{
            $data->status = $request->status;
            $data->start_date = Carbon::now('Asia/Jakarta')->toDateTimeString();
            $data->end_date = $endDate;
            if($data->save())
                return redirect(url('peminjaman-masuk/peminjaman-masuk'))->with('success','Berhasil Menerima Peminjaman Buku Siswa ');
            return redirect(url('peminjaman-masuk/'.$request->id.'/peminjaman-masuk'))->with('failed','Gagal Menerima Peminjamanan Buku Siswa');
        }
        // return $data;
    }
    public function extends(Request $request)
    {
        $data = LogExtends::find($request->id);
        if(!$data)
        {
            return response()->json(['error' => true, 'message' => 'Data not found!'], 200);
        }
        else{
            BooksOrder::where('book_id', $data->book_id)->update([
                'start_date' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
                'end_date' => Carbon::parse($data->end_date_book)->addDays($data->jumlah)->toDateTimeString(),
            ]);
            $data->status = 0;
            // dd($data);
            if($data->save())
                return redirect(url('management-peminjaman/extends'))->with('success','Berhasil Menerima perpanjang Buku Siswa ');
            return redirect(url('management-peminjaman/'.$request->id.'/extends'))->with('failed','Gagal Menerima perpanjangan Buku Siswa');
        }
    }

    public function booksOrder(Request $request){
        $data = BooksOrder::where('user_id',$request->user_id)->where('status','APPROVED')->get();
        return $data;
    }
}
