<?php

namespace App\Http\Controllers\AUTH;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/home';
    public function Login (Request $request){
        if(!$request->all())
            return view('auth.login');
        else{
            $rules = [
                'user_number'=> 'required|user_number',
                'password'   => 'required|string'
            ];
            $data= [
                'user_number'  => $request->input('username'),
                'password'  => $request->input('password'),
            ];
            Auth::attempt($data);
            if (Auth::check()) {
                if(Auth()->user()->user_type_id == 3){
                    return redirect()->route('main');
                }
                else{
                    return redirect()->route('main-user');
                }
    
            } else { // false
    
                //Login Fail
                Session::flash('error', 'Incorrect email or password');
                return redirect()->route('login');
            }
        }
        
        
    }
    public function Logout (){
        Session::flush();
        return redirect(url('/'));
    }
   
}
