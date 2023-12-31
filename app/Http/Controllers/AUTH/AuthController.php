<?php

namespace App\Http\Controllers\AUTH;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Events\ActionEvent;
use App\Models\ClassModel;
use App\Models\Unit;
use App\Models\User;

class AuthController extends Controller
{
    use AuthenticatesUsers;
    protected $redirectTo = '/home';
    public function LoginAuth(Request $request){
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);
        if(!$request->all())
        {
            return view('login');
        }
        else{
            $data = [
                'user_number' => $request->input('username'),
                'password' => $request->input('password'),
            ];
            Auth::attempt($data);
            if(Auth::check())
            {
                if(Auth()->user()->user_type_id == 3){
                    return redirect()->route('main');
                }
                else{
                    return 'ANDA TIDAK MEMEILIK AKSES KE HALAMAN ADMIN!!!!';
                }
            }else{
                return redirect(route('login'))->with('success' , 'Username Dan Password Salah' );
            }
        }
    }
    public function Login (Request $request){
        if(Auth::check()){
            return redirect(route('main'));
        }
        return view('auth.login');
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
    public function jobuser()
    {
        $data = User::where('user_type_id',1)->orderBy('created_at', 'DESC')->paginate(300);
        $array = [];
        foreach($data as $item){
            $array[] = $item;
            // $angkatan =  $item['unit_relation']->name;
            // $tmp = $item['user_number'];
            // $item->user_number = $angkatan."SIM".$tmp;
            // $item->save();
        }
        return $array;
        return "Berhasil Change";
    }
}
