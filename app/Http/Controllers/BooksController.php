<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Edition;
use App\Models\Locker;
use App\Models\Publisher;
use App\Models\Books;
use App\Models\BooksCategory;



// Call Service
use DataTables;
use Carbon\Carbon;


class BooksController extends Controller
{
    public function books (){
        $books = Books::where('deleted_at',null)->get();
        $author = Author::where('deleted_at',null)->get();
        $edition = Edition::where('deleted_at',null)->get();
        $locker = Locker::where('deleted_at',null)->get();
        $publisher = Publisher::where('deleted_at',null)->get();
        $category = BooksCategory::where('deleted_at',null)->get();
        return view ('books.index', compact('author', 'edition', 'locker', 'publisher', 'category'));
    }
    public function books_add(Request $request){
        $examplar = "";
        $queue_copy = !Books::max('queue_of_examplar') ? 1 : Books::max('queue_of_examplar') + 1;
        if($request->hasFile('cover')){
            $file = $request->file('cover');
            $fileName = $file->getClientOriginalName();
            if (!in_array($request->file('cover')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            $file->move('book-images/',$queue_copy.'BIMG-'.$file->getClientOriginalName());
            $pathCover = asset('book-images/'.$queue_copy.'BIMG-'.$file->getClientOriginalName());
        }
        for($i=0; $i<$request->copy_amount; $i++){
            $exist = Books::all();
            $queue = count($exist) == 0 ? 1 : count($exist) + 1;
            if(strlen($examplar) < 1){
                for($j=1; $j<8 - strlen(strval($queue_copy)); $j++){
                    $examplar .= "0";
                }
                $examplar.=strval($queue_copy);
            }
            $examplar;
            $copy = count(Books::where('examplar',$examplar)->get()) == 0 ? 1 : count(Books::where('examplar',$examplar)->get()) + 1;
            $examplar_number =$examplar.'/'.$request->origin_book.'/'.Carbon::now('Asia/Jakarta')->year.'/C'.$copy.'of'.$copy;
            Books::create([
                'name' => $request->name,
                'creator_id' => $request->creator_id,
                'publisher_id' => $request->publisher_id,
                'edition_id' => $request->edition_id,
                'locker_id' => $request->locker_id,
                'origin_book' => $request->origin_book,
                'book_number' => $queue,
                'buying_year' => Carbon::parse($request->buying_year)->format('Y-m-d H:m:s'),
                'publish_year' => Carbon::parse($request->publish_year)->format('Y-m-d H:m:s'),
                'queue_of_examplar' => $queue_copy,
                'examplar' => $examplar,
                'code_of_book' => $examplar_number,
                'call_number' => $examplar.'-'.$queue,
                'description' => "no",
                'cover' => $pathCover ?? null,
            ]);
        }     
        return response()->json(['error' => false, 'message' => 'Berhasil menambahkan data buku baru'], 200);

    }
    public function booksDatatable(){
        $data = Books::where('deleted_at',null)->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){

            $edit = '<button  key="'.$data['id'].'" data-toggle="modal" data-target="#addTeacher"  class="btn btn-info p-1 text-white" onclick="getEditBookComponent('.$data['id'].')" id="btn-edit"> <i class="fa fa-edit"> </i> </button>';
            return $edit;
        })
        ->make(true);
    }
    public function booksDatatableExamplar(){
        $data = Books::where('deleted_at',null)->distinct('examplar')->get(['name','examplar']);
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('copy_amount',function($data){
            return count(Books::where('examplar', $data['examplar'])->get());
        })
        ->addColumn('action', function($data){
            $detailLink = "'".route('book-detail',[$data['examplar']])."'";
            $edit = '<button onclick="document.location.href='.$detailLink.'"  class="btn btn-info p-1 text-white" id="btn-edit"> <i class="fa fa-eye"> </i> </button>';
            return $edit;
        })
        ->make(true);
    }
    public function booksDetail($examplar){
        $data = Books::where('examplar', $examplar)->first();
        $data['copy_amount'] = count(Books::where('examplar', $examplar)->get()); 
        return view('books.book-detail', compact('data'));
    }
    public function booksDelete(Request $request){
        $data = Books::where('examplar', $request->examplar)->orderBy('book_number','DESC')->first();
        $data->delete();
        return response()->json(['error' => false, 'message' => 'Berhasil menghapus data' ], 200);
    }
}
