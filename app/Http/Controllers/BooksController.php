<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Edition;
use App\Models\Locker;
use App\Models\Publisher;
use App\Models\Books;
class BooksController extends Controller
{
    public function books (){
        $books = Books::where('deleted_at',null)->get();
        $author = Author::where('deleted_at',null)->get();
        $edition = Edition::where('deleted_at',null)->get();
        $locker = Locker::where('deleted_at',null)->get();
        $publisher = Publisher::where('deleted_at',null)->get();
        return view ('books.index', compact('author', 'edition', 'locker', 'publisher'));
    }
    public function books_add(Request $request){
        $books = Books::where('deleted_at',null)->get();
        $author = Author::where('deleted_at',null)->get();
        $edition = Edition::where('deleted_at',null)->get();
        $locker = Locker::where('deleted_at',null)->get();
        $publisher = Publisher::where('deleted_at',null)->get();
        if(!$request->all())
            return view ('books.index', compact('author', 'edition', 'locker', 'publisher'));
            
        else{
            $insert = $request->validate([
                'name' => 'required|max:30|min:2,'
            ]);
            $insert = Books::create($request->all());
            if($insert)
                return redirect(route('books'))->with('success', 'Success stored new city data');
        }
    }
}
