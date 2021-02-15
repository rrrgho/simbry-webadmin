<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class BooksOrder extends Model
{
    use HasFactory;
    protected $table = "book_order";
    protected $guarded = [];
    protected $appends = ['book'];

    public function book_relation(){
        return $this->belongsTo(Books::class, 'book_id');
    }
    public function getBookAttribute(){
        return $this->book_relation ?? '-';
    }
    public function User(){
        return $this->belongsTo(User::class);
    }
}
