<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GameLevel extends Model
{
    use HasFactory;
    protected $table = "game_level";
    protected $guarded = [];
}
