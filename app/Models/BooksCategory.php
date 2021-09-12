<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BooksCategory extends Model
{
    use HasFactory;
    protected $table = "book_category";
    protected $guarded = [];

    public function book_relation()
    {
        return $this->hasMany(Books::class,'category_id');
    }
}
