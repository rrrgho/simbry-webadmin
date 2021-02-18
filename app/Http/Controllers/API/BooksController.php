<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Model
use App\Models\Books;

class BooksController extends Controller
{
    public function bookData(){
        $data = Books::paginate(3);
        return response()->json(['error'=>false, 'message'=>'Success retrived data', 'data' => $data], 200);
    }
}
