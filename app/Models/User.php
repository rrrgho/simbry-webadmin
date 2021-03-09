<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use App\Models\BooksOrder;
use App\Models\GameLevel;
use Carbon\Carbon;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;
    use HasApiTokens;
    protected $table = "user";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $dates = [
        'updated_at',
        'created_at',
        'deleted_at',
        'email_verified_at',
        'last_login_at',
    ];
    protected $fillable = [
        'name',
        'user_number',
        'class_id',
        'user_type_id',
        'password',
        'last_login_at',
    ];
    protected $appends = ['level'];

    public function class_relation(){
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }

    public function order(){
        return $this->hasMany(BooksOrder::class);
    }
    public function kritik(){
        return $this->hasMany(KritikSaran::class);
    }
    public function class()
    {
        return $this->hasMany(ClassModel::class,'name');
    }

    // Game Level
    public function getLevelAttribute(){
        $level = "";
        $orderTotal = BooksOrder::where('user_id',$this->id)->count();
        $thisMonthOrder = BooksOrder::where('user_id',$this->id)->whereMonth('created_at',Carbon::now('Asia/Jakarta')->month)->first();
        $gameLevel = GameLevel::all();
        for($i=0; $i<count($gameLevel); $i++){
            if($orderTotal >= $gameLevel[$i]->amount){
                if($thisMonthOrder)
                    $level = $gameLevel[$i]->name;
                else
                    if($i>0)
                        $level = $gameLevel[$i-1]->name;
                    else
                        $level = $gameLevel[$i]->name;
            }else{
                break;
            }
        }
        return $level;
    }
    
}
