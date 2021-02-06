<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Migrated extends Model
{
    use HasFactory;
    protected $table = "migrated";
    protected $guarded = [];
}
