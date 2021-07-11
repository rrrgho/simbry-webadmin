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
    // protected $fillable = [
    //     'user_id','book_id','status','start_date','end_date' 
    //  ];
    public function book_relation(){
        return $this->belongsTo(Books::class, 'book_id');
    }
    public function getBookAttribute(){
        return $this->book_relation ?? '-';
    }
    public function user_relation(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    public function getUserAttribute(){
        return $this->user_relation ?? '-';
    }
    public function class_relation(){
        return $this->belongsTo(ClassModel::class, 'class_id', 'id');
    }
    // public function user_relation(){
    //     return $this->belongsTo(User::class, 'user_id', 'id');
    // }
    public function lates_relation()
    {
        return $this->belongsTo(Late::class, 'user_id','id');
    }
    // public function User(){
    //     return $this->belongsTo(User::class, 'user_id');
    // }
}
