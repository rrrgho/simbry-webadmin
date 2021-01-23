<?php

namespace App\Http\Controllers\AUTH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;

class AuthController extends Controller
{
    public function Login (Request $request){
        if(!$request->all())
            return view('auth.login');


        // When login success
        Session::put('admin','ohyeah');
        return response()->json(['error' => false, 'message' => 'login success'], 200);
    }
    public function Logout (){
        Session::flush();
        return redirect(url('/'));
    }
}
