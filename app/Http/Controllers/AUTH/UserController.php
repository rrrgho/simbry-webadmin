<?php

namespace App\Http\Controllers\AUTH;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class UserController extends Controller
{
    public function UserLogin(Request $request){
        $data= [
            'user_number'  => $request->input('username'),
            'password'  => $request->input('password'),
        ];
        Auth::attempt($data);
            if (Auth::check()) {
                if(Auth()->user()->user_type_id == 2){
                    return response()->json(['error' => false, 'message' => 'Login success !', 'data' => $data], 200);
                }
                else{
                    return response()->json(['error' => true, 'message' => 'Password is wrong'], 401);
                }
    
            } else { // false
    
                //Login Fail
                return response()->json(['error' => true, 'message' => 'Email not found !'], 401);
            }
    }
}
