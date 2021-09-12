<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Locker extends Model
{
    use HasFactory;
    protected $table = "book_locker";
    protected $guarded = [];
    public function book_relation()
    {
        return $this->hasMany(Books::class, 'locker_id');
    }
    protected $appends = ['jumlah_buku'];
    public function getJumlahBukuAttribute()
    {
        return count($this->book_relation()->get());
    }
}
