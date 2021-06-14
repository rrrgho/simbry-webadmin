<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Model
use App\Models\Books;
use App\Models\BooksCategory;
use App\Models\Locker;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class BooksController extends Controller
{
    public function bookData(){
        $data = Books::paginate(3);
        // $data = Books::with;
        // $data['category'] = BooksCategory::find($data['category_id'])['name'];
        // $data['locker'] = Locker::find($data['locker_id'])['name'] ?? '-';
        return response()->json(['error'=>false, 'message'=>'Success retrived data', 'data' => $data], 200);
    }
    public function bookDetail($id){
        $data = Books::find($id);
        $data['category'] = BooksCategory::find($data['category_id'])['name'];
        $data['locker'] = Locker::find($data['locker_id'])['name'] ?? '-';
        $data['stock'] = Books::where('examplar',$data['examplar'])->where('ready',true)->get()->count();
        return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data], 200);
    }
    public function bookSearch(Request $request){
        $data = Books::where('name', 'like', '%' . $request->judul . '%')->paginate(50);
        return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data], 200);
    }
    public function bookQrDetail($id)
    {
        $data = Books::find($id);
        return response()->json([
            'message' => true,
            'data' => [
                'id' => $data->id,
                'examplar' => $data->examplar,
                'name' => $data->name,
                'ready' => $data->ready,
                'link_admin' => asset("/books-management/books-detail/".$data->id),
                'link_user_unsecure' => "http://ypsimlibrary.com/book-detail/".$data->id,
                'link_user_secure' => "https://ypsimlibrary.com/book-detail/1".$data->id, 
            ],
        ]);
    }
}
