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
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use  HasFactory, Notifiable;
    use HasApiTokens;
    protected $table = "user";
    use SoftDeletes;

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
        'unit',
        'point',
    ];
    protected $hidden = ['password'];
    protected $appends = ['level','class_name','unit_name'];

    public function class_relation(){
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }
    public function unit_relation(){
        return $this->belongsTo(Unit::class, 'unit', 'id');
    }
    public function order_relation(){
        return $this->belongsTo(BooksOrder::class, 'user_id', 'id');
    }
    public function order(){
        return $this->hasMany(BooksOrder::class)->where('status','APPROVED');
    }
    public function kritik(){
        return $this->hasMany(KritikSaran::class);
    }
    public function class()
    {
        return $this->hasMany(ClassModel::class,'name');
    }
    // public function game_relation()
    // {
    //     return $this->belongsTo(GameLevel::class,'amount');
    // }
    // Game Level
    // public function getLevelAttribute()
    // {
    //     return $this->game_relation;


    // }
    public function getLevelAttribute(){
        $level = "";
        $pointVar = "";
        $orderTotal = $this->point;
        if($this->point == null)
        {
            $pointVar = 0;
        }
        if($this->point >= 30)
        {
            $level = "PLATINUM";
        }else{
            $gameLevel = GameLevel::where('amount',$orderTotal ? $orderTotal : $pointVar)->get();
            foreach($gameLevel as $item)
            {
                $level = $item->name;
            }
        }
        return $level;
        // $thisMonthOrder = BooksOrder::where('user_id',$this->id)->whereMonth('created_at',Carbon::now('Asia/Jakarta')->month)->first();
        // $gameLevel = GameLevel::all();
        // for($i=0; $i<count($gameLevel); $i++){
        //     if($orderTotal == $gameLevel[$i]->amount){
        //         if($thisMonthOrder)
        //             $level = $gameLevel[$i]->name;
        //         else
        //             if($i>0)
        //                 $level = $gameLevel[$i-1]->name;
        //             else
        //                 $level = $gameLevel[$i]->name;
        //     }else{
        //         break;
        //     }
        // }
    }

    public function getClassNameAttribute(){
        return $this->class_relation->name ?? '-';
    }

    public function getUnitNameAttribute(){
        return $this->unit_relation->name ?? '-';
    }

}
