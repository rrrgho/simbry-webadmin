<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Books extends Model
{

    use HasFactory;
    protected $table = "book";
    protected $guarded = [];
    // protected $hidden = ['category_relation','locker_relation','publisher_relation'];
    protected $hidden = ['sub_category'];
    public function category_relation(){
        return $this->belongsTo(BooksCategory::class, 'category_id');
    }
    // public function getCategoryAttribute(){
    //     return $this->category_relation->name ?? '-';
    // }

    public function locker_relation(){
        return $this->belongsTo(Locker::class, 'locker_id');
    }
    // public function getLockerAttribute(){
    //     return $this->locker_relation->name ?? '-';
    // }

    public function publisher_relation(){
        return $this->belongsTo(Publisher::class, 'publisher_id');
    }
    // public function getPublisherAttribute(){
    //     return $this->publisher_relation->name ?? '-';
    // }
}
