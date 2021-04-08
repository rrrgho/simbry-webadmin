<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Announcement;
use App\Models\Books;
use App\Models\BooksOrder;
use App\Models\Contact;
use App\Models\KritikSaran;
use App\Models\Late;
use App\Models\Popular;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Models\User;
use DateTime;
use Illuminate\Console\Scheduling\Event;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;





class UserController extends Controller
{

    public function Login(Request $request)
    {
        $user = User::where('user_number', $request->user_number)->first();
        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $data['token'] = $user->createToken('nApp')->accessToken;
                $data['id'] = $user->id;
                $data['user_number'] = $user->user_number;
                $data['name'] = $user->name;
                $data['level'] = $user->level;
                $user->update([
                    'last_login_at' => Carbon::now()->toDateTimeString(),
                ]);
                return response()->json(['error' => false, 'message' => 'Login success !', 'data' => $data], 200);
            }
            return response()->json(['error' => true, 'message' => 'Password is wrong'], 200);
        }
        return response()->json(['error' => true, 'message' => 'Username not found !'], 200);
    }       
    public function changePassword(Request $request)
    {
        $input = $request->all();
        $user_id = Auth::guard('api')->user()->id;
        $rules = array(
            'old_password' => 'required',
            'new_password' => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        );
        $validator = Validator::make($input, $rules);
        if ($validator->fails()) {
            $arr = array("status" => 400, "message" => $validator->errors()->first(), "data" => array());
        } else {
            try {
                if ((Hash::check(request('old_password'), Auth::user()->password)) == false) {
                    $arr = array("status" => 400, "message" => "Check your old password.", "data" => array());
                } else if ((Hash::check(request('new_password'), Auth::user()->password)) == true) {
                    $arr = array("status" => 400, "message" => "Please enter a password which is not similar then current password.", "data" => array());
                } else {
                    User::where('id', $user_id)->update(['password' => Hash::make($input['new_password'])]);
                    $arr = array("status" => 200, "message" => "Password updated successfully.", "data" => array());
                }
            } catch (\Exception $ex) {
                if (isset($ex->errorInfo[2])) {
                    $msg = $ex->errorInfo[2];
                } else {
                    $msg = $ex->getMessage();
                }
                $arr = array("status" => 400, "message" => $msg, "data" => array());
            }
        }
        return response()->json($arr);
    } 
      
    public function orderBook(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'book_id' => ['required'],
        ]);
        $late = Late::where('user_id', Auth::guard('api')->id())->where('date','>', now()->toDateTimeString())->exists();
        if($late){
            return response()->json(['error' => true, 'message' => 'Belum boleh pinjem, Mohon Tunggu'],200);
        }
        $userType = Auth::guard('api')->user()->user_type_id;
        $unfinishedOrder = BooksOrder::where('user_id', Auth::guard('api')->id())->where('status', '<>', 'finished')->count();
        if (($userType == 1 && $unfinishedOrder > 1) || ($userType == 2 && $unfinishedOrder > 2))  {
            return response()->json(['error' => true, 'message' => 'Peminjaman sudah melebihi batas'],200);
        } 
        
        $data = Books::where('id', $validated['book_id'])->where('ready', true)->orderBy('created_at', 'DESC')->first();
        
        if (!$data) {
            return response()->json(['error' => true, 'message' => 'Data not found!'], 200);
        }
        try {
            DB::transaction(function () use ($data) {
                $data->ready = false;
                $data->borrowed = $data['borrowed'] + 1;
                $userType = Auth::guard('api')->user()->user_type_id;
                if ($userType == 1) {
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
            return response()->json(['error' => true, 'message' => $e], 200);
        }
        return response()->json([
            'error' => false, 'message' => 'Permohonam peminjaman sedang diproses oleh Admin, cek sekala berkala status peminjaman anda !'
        ], 200);
    }
    public function historybook(){
        $data = BooksOrder::where('user_id', Auth::guard('api')->user()->id)->orderBy('created_at','DESC')->paginate(1);
        if (!$data) {
            return response()->json(['error' => true, 'message' => 'Data not found!'], 200);
        }
        else{
            if($data)
                return response()->json(['error' => false, 'message' => 'succes data', 'data' => $data],200);
            return response()->json(['error' => true, 'message' => 'Gagal!'], 401);
        }

    }
    public function kritik(Request $request){
        $data = KritikSaran::create([
            'user_id' => Auth::guard('api')->user()->id,
            'deskripsi' => $request->deskripsi,
        ]);
        if($data)
            return response()->json(['error' => true, 'message' => 'Terimakasih!', 'data' => $data], 200);
        return response()->json(['error' => true, 'message' => 'Gagal!'], 401);     
    }
    public function rating(Request $request)
    {
        $data = Books::orderBy('borrowed', 'DESC')->take(10)->get();     
        if (!$data) {
            return response()->json(['error' => true, 'message' => 'Data not found!'], 200);
        }
        else{
            if($data)
                return response()->json(['error' => false, 'message' => 'succes data', 'data' => $data],200);
            return response()->json(['error' => true, 'message' => 'Gagal!'], 401);
        }

    }
    public function announcement()
    {
        $data = Announcement::where('deleted_at',null)->orderBy('created_at', 'DESC')->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'succes data', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Gagal!'], 401);
    }
    public function studentPopular($unit){
        $data = Popular::with('user')->where('deleted_at',null)->where('unit_id', $unit)->whereMonth('created_at', Carbon::now('Asia/Jakarta')->month)->orderBy('point','DESC')->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'succes data', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Gagal!'], 401);
    }
    public function slideBanner()
    {
        $data = Slide::where('deleted_at',null)->where('active',true)->orderBy('created_at', 'DESC')->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'succes data', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Gagal!'], 401);
    }
    public function contact(){
        $data = Contact::where('deleted_at',null)->orderBy('created_at', 'DESC')->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'succes data', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Gagal!'], 401);
    }
    public function about(){
        $data = About::where('deleted_at',null)->orderBy('created_at', 'DESC')->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'succes data', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Gagal!'], 401);
    }
}
