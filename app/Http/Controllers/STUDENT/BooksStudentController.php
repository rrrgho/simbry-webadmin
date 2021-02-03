<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Model
use App\Models\Books;

class BooksStudentController extends Controller
{
    public function index(Request $request)
    {   
        // $books = Books::paginate(4);
        $books = Books::select(['examplar','name','cover'])->distinct('examplar')->paginate(2);
        if($request->all())
            $books = Books::select(['examplar','name','cover'])->where('name', 'like', '%'.$request->judul.'%')->distinct('examplar')->paginate(2);
        foreach($books as $item){
            $addRelation = Books::where('examplar',$item['examplar'])->first();
            $item['category_name'] = $addRelation['category'];
            $item['publisher_name'] = $addRelation['publisher'];
            $item['locker_name'] = $addRelation['locker'];
            $item['edition_name'] = $addRelation['edition'];
        }
        return view('users.index', compact('books'));
    }
}
