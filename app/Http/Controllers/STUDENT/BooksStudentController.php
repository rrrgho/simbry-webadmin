<?php

namespace App\Http\Controllers\STUDENT;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

// Call Model
use App\Models\Books;
use App\Models\BooksOrder;

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

    public function orderBook(Request $request){
        $data = Books::where('examplar',$request->examplar)->where('ready', true)->orderBy('created_at','DESC')->first();
        $data->ready = false;
        BooksOrder::create([
            'user_id' => $request->id,
            'book_id' => $data->id,
            'status' => 'PENDING',
        ]);
        $data->save();
        return response()->json(['error' => false, 'message' => 'Permohonam peminjaman sedang diproses oleh Admin, cek sekala berkala status peminjaman anda !'], 200);
    }

    public function userShowBookComponent(Request $request){
        // $books = Books::select(['examplar','name','cover'])->distinct('examplar')->paginate(10);
        // if($request->all())
        //     $books = Books::select(['examplar','name','cover'])->where('name', 'like', '%'.$request->judul.'%')->distinct('examplar')->paginate(2);
        // foreach($books as $item){
        //     $addRelation = Books::where('examplar',$item['examplar'])->first();
        //     $item['category_name'] = $addRelation['category'];
        //     $item['publisher_name'] = $addRelation['publisher'];
        //     $item['locker_name'] = $addRelation['locker'];
        //     $item['edition_name'] = $addRelation['edition'];
        // }

        $books = Books::paginate(3);
        if($request->judul)
            $books = Books::where('name', 'like', '%'.$request->judul.'%')->get();
        return view('users.Home.component-show-book', compact('books'));
    }

    public function userShowOrderComponent(){
        $id = Auth::user()->id;
        $order = BooksOrder::where('user_id',$id)->where('status','<>','DONE')->get();
        return view('users.Home.component-show-order', compact('order'));
    }
}
