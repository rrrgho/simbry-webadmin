<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Preference extends Model
{
    use HasFactory;
    protected $table = 'category_preference';
    protected $guarded = [];
    public function Category()
    {
        return $this->belongsTo(BooksCategory::class,'category_id','id');
    }
    public function book_relation()
    {
        return $this->hasMany(Books::class,'category_id');
    }

}
