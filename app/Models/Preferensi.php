<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preferensi extends Model
{
    use HasFactory;
    protected $table = 'preferensi';
    protected $guarded = [];
    protected $appends = ['user'];
    public function user_relation(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getUserAttribute(){
        return $this->user_relation ?? '-';
    }
}
