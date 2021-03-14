<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Late extends Model
{
    use HasFactory;
    protected $table = "lates";
    protected $guarder = [];
    protected $fillable = [
        'user_id',
        'date'
    ];
}
