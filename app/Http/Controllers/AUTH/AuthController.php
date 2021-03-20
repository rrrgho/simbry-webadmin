<?php

namespace App\Http\Controllers\AUTH;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Events\ActionEvent;

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
                    return 'ANDA TIDAK MEMEILIK AKSES KE HALAMAN ADMIN!!!!';
                }
    
            } else { // false
    
                //Login Fail
                return redirect(route('login'))->with('success' , 'Username Dan Password Salah' );
            }
        }
        
        
    }
    public function Logout (){
        Session::flush();
        return redirect(url('/'));
    }

    public function Redis(){
        $actionId = "score_update";
        $actionData = array("team1_score" => 46);
        event(new ActionEvent($actionId, $actionData));
    }
   
}
