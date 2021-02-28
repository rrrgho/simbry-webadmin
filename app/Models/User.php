<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


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
    
}
