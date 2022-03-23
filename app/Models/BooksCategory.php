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
    public function sub_relation()
    {
        return $this->belongsTo(SubCategory::class,'sub_category','id');
    }
    protected $appends = ['jumlah_buku','sub_category_name','id_sub'];
    public function getSubCategoryNameAttribute()
    {
        return $this->sub_relation->name ?? NULL;
    }
    public function getIdSubAttribute()
    {
        return $this->sub_relation->id ?? NULL;
    }
    public function getJumlahBukuAttribute(){
        return count($this->book_relation()->get());
    }
}
