<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// Call Model
use App\Models\Books;
use App\Models\BooksOrder;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class BooksStudentController extends Controller
{
   

    public function orderBook(Request $request){
        $data = Books::where('id', $request->id)->where('ready', true)->orderBy('created_at', 'DESC')->first();
            if (!$data) {
                return response()->json(['error' => true, 'message' => 'Data not found!'], 200);
            }
            try {
            DB::transaction(function () use ($data) {
            $data->ready = false;
            $userType = Auth::guard('api')->user()->user_type_id;
            if ( $userType == 1) {
            $endDate = Carbon::now('Asia/Jakarta')->addDays(2)->toDateTimeString();
            } else {
            $endDate = Carbon::now('Asia/Jakarta')->addDays(3)->toDateTimeString();
            }
            BooksOrder::create([
            'user_id' => Auth::guard('api')->user()->id,
            'book_id' => $data->id,
            'status' => 'PENDING',
            'start_date' => Carbon::now('Asia/Jakarta')->toDateTimeString(),
            'end_date' => $endDate
            ]);
            $data->save();
            });
            } catch (\Exception $e) {
            return response()->json(['error' => true,'message' => 'Simpan data error'], 200);
            }
            return response()->json(['error' => false,'message' => 'Permohonam peminjaman sedang diproses oleh Admin, cek sekala berkala status peminjaman anda !'
            ], 200);
    }

}
