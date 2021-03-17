<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Popular extends Model
{
    use HasFactory;
    protected $table = "popular";
    protected $guarded = [];
    protected $fillable = [
        'user_id',
        'unit_id',
        'point'
    ];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }
}
