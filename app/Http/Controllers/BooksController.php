<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Author;
use App\Models\Edition;
use App\Models\Locker;
use App\Models\Publisher;
use App\Models\Books;
use App\Models\BooksCategory;
use App\Models\Migrated;
use App\Models\User;
use SimpleSoftwareIO\QrCode\Generator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
// Call Service
use DataTables;
use Carbon\Carbon;
use Intervention\Image\Facades\Image;


class BooksController extends Controller
{
    public function books (){
        $locker = Locker::where('deleted_at',null)->get();
        $publisher = Publisher::where('deleted_at',null)->get();
        $category = BooksCategory::where('deleted_at',null)->get();
        return view ('books.index', compact('locker', 'publisher', 'category'));
    }
    public function books_add(Request $request){
        $examplar = "";
        $number = "";
        $queue_copy = !Books::max('queue_of_examplar') ? 1 : Books::max('queue_of_examplar') + 1;
        if($request->hasFile('cover')){
            $file = $request->file('cover');
            $fileName = $file->getClientOriginalName();
            $resize = Image::make($file);
            $resize->resize(300,300);
            if (!in_array($request->file('cover')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            // $resize->move('book-images/',$queue_copy.'BIMG-'.$file->getClientOriginalName());
            $resize->save(public_path('book-images/'.$queue_copy.'BIMG-'.$file->getClientOriginalName()));
            // $resize->save($file->getClientOriginalName());
            $pathCover = asset('book-images/'.$queue_copy.'BIMG-'.$file->getClientOriginalName());
        }
        if($request->hasFile('link_pdf')){
            $file = $request->file('link_pdf');
            $fileName = $file->getClientOriginalName();
            if (!in_array($request->file('link_pdf')->getClientOriginalExtension(), array('pdf', 'pdf', 'pdf'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only Pdf!'], 200);
            $file->move('pdf/',$queue_copy.'BIMG-'.$file->getClientOriginalName());
            $pathPdf = asset('pdf/'.$queue_copy.'BIMG-'.$file->getClientOriginalName());
        }
        for($i=0; $i<$request->copy_amount; $i++){
            $queue = Migrated::find(3);
            if(strlen($examplar) < 1){
                for($j=1; $j<8 - strlen(strval($queue_copy)); $j++){
                    $examplar .= "0";
                }
                $examplar.=strval($queue_copy);
            }
            if(strlen($queue['value'])<=6){
                for($k=1; $k<=6-strlen($queue['value']); $k++)
                    $number.="0";
                $number.=$queue['value'];
            }
            else
                $number.=strval($queue['value']);
            $examplar;
            $copy = count(Books::where('examplar',$examplar)->get()) == 0 ? 1 : count(Books::where('examplar',$examplar)->get()) + 1;
            $examplar_number =$examplar.'/'.Carbon::now('Asia/Jakarta')->year.'/C'.$copy.'of'.$request->copy_amount;
            $insert = Books::create([
                'name' => $request->name,
                'category_id' => $request->category_id,
                'creator' => $request->creator,
                'publisher_id' => $request->publisher_id,
                'edition' => $request->edition,
                'locker_id' => $request->locker_id,
                'origin_book' => $request->origin_book,
                'book_number' => $number.'-'.Carbon::now('Asia/Jakarta')->year,
                'buying_year' => Carbon::parse($request->buying_year)->year,
                'publish_year' => Carbon::parse($request->publish_year)->year,
                'queue_of_examplar' => $queue_copy,
                'examplar' => $examplar,
                'code_of_book' => $examplar_number,
                'call_number' => $request->call_number ?? $examplar.'-'.$queue['value'],
                'description' => $request->description ?? null,
                'cover' => $pathCover ?? null,
                'link_pdf' => $pathPdf ?? null,
                'no_panggil' => $request->no_panggil,
            ]);
            if($insert){
                $number = "";
                $queue->value = $queue['value'] + 1;
                $queue->save();
            }
        }
        return response()->json(['error' => false, 'message' => 'Berhasil menambahkan data buku baru'], 200);

    }
    public function booksDatatable(){
        $data = Books::with(['category_relation','locker_relation','publisher_relation'])->where('deleted_at',null)->orderBy('created_at','DESC');
        // return $data;
        return Datatables::eloquent($data)
        ->addColumn('action', function($data){

            $edit = '<a href="'.route('book-detail', [$data['examplar']]).'" class="btn btn-info p-1 text-white" id="btn-edit"> <i class="fa fa-sign-out"> </i> </a>';
            return $edit;
        })
        ->addColumn('locker', function($data){
            return $data['locker_relation']['name'] ?? '-';
        })
        ->make(true);
    }
    public function booksQR(Request $request)
    {
        $data = Books::simplePaginate(5);
        return view('books.qrcode',compact('data'));
    }
    public function booksDatatableExamplar(){
        $data = Books::where('deleted_at',null)->distinct('examplar')->where('id','<', 100)->get(['name','examplar']);
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
        $data = Books::where('examplar', $examplar)->where('deleted_at',null)->get();
        $user = User::where('deleted_at',null)->get();
        $locker = Locker::where('deleted_at',null)->get();
        $publisher = Publisher::where('deleted_at',null)->get();
        $category = BooksCategory::where('deleted_at',null)->get();
        $qrcode = QrCode::size(150)->generate(env('APP_URL').'/api/book-qr/'.$examplar);
        return view('books.book-detail', compact('data','user','locker', 'publisher', 'category','qrcode'));
    }
    public function bookQrDetail($examplar)
    {
        $data = Books::find($examplar);
        return response()->json([
            'message' => true,
            'data' => [
                'id' => $data->id,
                'examplar' => $data->examplar,
                'name' => $data->name,
                'ready' => $data->ready,
            ],
        ]);
    }
    public function booksDelete(Request $request){
        $item = Books::find($request->id);
        $sameBook = Books::where('examplar', $item->examplar)->where('deleted_at',null)->get();
        $queue_on_same_book = 1;
        foreach($sameBook as $book){
            $code = "";
            for($i=0; $i<13; $i++){
                $code.=$book['code_of_book'][$i];
            }
            $code.='C'.$queue_on_same_book.'of'.strval(count($sameBook)-1);
            $book->code_of_book = $code;
            $book->save();
            if($queue_on_same_book < count($sameBook))
                $queue_on_same_book++;
        }
        $item->deleted_at = Carbon::now('Asia/Jakarta');
        $item->save();
        return response()->json(['error' => false], 200);
    }
    public function booksDuplicate(Request $request){
        $sameBook = Books::where('examplar', $request->examplar)->where('deleted_at',null)->get();
        $queue_on_same_book = 1;
        foreach($sameBook as $book){
            $code = "";
            for($i=0; $i<13; $i++){
                $code.=$book['code_of_book'][$i];
            }
            $code.='C'.$queue_on_same_book.'of'.strval(count($sameBook)+1);
            $book->code_of_book = $code;
            $book->save();
            if($queue_on_same_book < count($sameBook))
                $queue_on_same_book++;
        }

        $queue = Migrated::find(3);
        $data = Books::where('examplar', $request->examplar)->first();
        $examplar_number =$data->examplar.'/'.Carbon::now('Asia/Jakarta')->year.'/C'.strval(count($sameBook)+1).'of'.strval(count($sameBook)+1);
        $number = "";
        if(strlen($queue['value'])<=6){
            for($k=1; $k<=6-strlen($queue['value']); $k++)
                $number.="0";
            $number.=$queue['value'];
        }
        else
            $number.=strval($queue['value']);
        Books::create([
            'name' => $data->name,
            'category_id' => $data->category_id,
            'creator' => $request->creator,
            'publisher_id' => $request->publisher_id,
            'edition' => $request->edition,
            'locker_id' => $request->locker_id,
            'origin_book' => $request->origin_book,
            'book_number' => $number.'-'.Carbon::now('Asia/Jakarta')->year,
            'buying_year' => Carbon::parse($request->buying_year)->year,
            'publish_year' => Carbon::parse($request->publish_year)->year,
            'queue_of_examplar' => $data->queue_of_examplar,
            'examplar' => $data->examplar,
            'code_of_book' => $examplar_number,
            'call_number' => $request->call_number ?? $data->examplar.'-'.$queue['value'],
            'description' => $request->description ?? null,
            'link_pdf' => $data->link_pdf ?? null,
            'no_panggil' => $request->no_panggil,
        ]);
        $queue->value = $queue['value'] + 1;
        $queue->save();
        return redirect(route('book-detail',[$data->examplar]))->with('success','Berhasil menduplikasi buku');
    }
    public function booksDetailUser($examplar){
        $data = Books::where('examplar', $examplar)->first();
        $books = Books::select(['examplar','name','cover'])->distinct('examplar')->paginate(2);
        $copy['copy_amount'] = count(Books::where('examplar', $examplar)->get());
        // $redy = Books::where('examplar');
        $redy['redy'] = count(Books::where('examplar', $examplar)->get());
        $item['category_name'] = $data['category'];
        $item['publisher_name'] = $data['publisher'];
        $item['locker_name'] = $data['locker'];
        $item['edition_name'] = $data['edition'];
        return view('books.book-detail-user', compact('data','books','item','copy','redy'));
    }
    // public function booksEdit(){
    //     $data = Books::where('deleted_at',null)->get();
    //     return view('books.ajax-books-edit', compact('data'));
    // }
    public function booksEditExecute(Request $request, $examplar){
        $data = Books::where('examplar', $examplar)->first();
        if($request->hasFile('link_pdf')){
            $file = $request->file('link_pdf');
            $fileName = $file->getClientOriginalName();
            if (!in_array($request->file('link_pdf')->getClientOriginalExtension(), array('pdf', 'pdf', 'pdf'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only Pdf!'], 200);
            $file->move('pdf/',$data.'BIMG-'.$file->getClientOriginalName());
            $pathPdf = asset('pdf/'.$data.'BIMG-'.$file->getClientOriginalName());
        }
        if(!$request->all())
            return view('books.book-detail', compact('data','books','item','copy','redy'));
        $data->name = $request->name;
        $data->category_id = $request->category_id;
        $data->creator = $request->creator;
        $data->locker_id = $request->locker_id;
        $data->origin_book = $request->origin_book;
        $data->link_pdf = $request->link_pdf;
        $data->no_panggil = $request->no_panggil;
        if($data->save())
            return redirect(url('books-management/books-detail/'.$data['examplar']))->with('success', 'Books is Edited !');
        return redirect(url('books-management/books-detail/'.$data['examplar']))->with('failed', 'Books is failed to be edited, contact developer !');
    }

    public function printQR(Request $request){
        $id = $request->data;
        return view('books.qr-data', compact('id'));
    }

    public function qrPage($data){
        $data =  json_decode($data,true);
        return view('books.print-qr', compact('data'));
    }

}
