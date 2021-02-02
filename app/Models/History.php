<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class History extends Model
{
    use HasFactory;
    protected $table = "book_order";
    protected $guarded = [];
    public function getStartAttribute(){
        return Carbon::parse($this->attributes['start_date'])
            ->translatedFormat('1, d F Y');
    }
    public function getEndAttribute(){
        return Carbon::parse($this->attributes['end_date'])
            ->translatedFormat('1, d F Y');
    }

}
