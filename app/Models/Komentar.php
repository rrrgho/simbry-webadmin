<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komentar extends Model
{
    use HasFactory;
    protected $table = 'komentars';
    protected $guarded = [];
    protected $hidden = ['user_id'];
    // public function book_relation(){
    //     return $this->belongsTo(Books::class, 'book_id');
    // }
    // public function getBookAttribute(){
    //     return $this->book_relation ?? '-';
    // }
    // public function user_relation(){
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }
    // public function getUserAttribute(){
    //     return $this->user_relation ?? '-';
    // }
}
