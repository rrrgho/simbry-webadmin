<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Model
use App\Models\Books;
use App\Models\BooksCategory;
use App\Models\BooksOrder;
use App\Models\Komentar;
use App\Models\Like;
use App\Models\Locker;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Stmt\Foreach_;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
class BooksController extends Controller
{
    public function bookData(){
        // $data = Books::paginate(6);
        $data = Books::orderBy('created_at', 'DESC')->paginate(6);
        // $data['locker'] = Locker::find($data['locker_id'])['name'] ?? '-';
        return response()->json(['error'=>false, 'message'=>'Success retrived data', 'data' => $data], 200);
    }
    public function getBookbyPreference()
    {
        $preferences = Preference::where('user_id', Auth::guard('api')->user()->id)->get();
        $query = [
            ['category_id', $preferences[1]['category_id']]
        ];

        $i=0;
        foreach( $preferences as $preference){
            if($i!=0)
                $query[] = ['category_id', $preference['category_id']];
            $i++;
        }
        // return $query;
        return Books::where([
            [
                "category_id",
                $preferences[0]['category_id']
            ],
        ])
        ->orWhere($query)
        ->paginate(6);
    }
    public function bookDataM()
    {
        $data = Books::orderBy('created_at', 'DESC')->paginate(6);
        // return $data['category_id'];
        // $data['category'] = Preference::where('user_id',Auth::guard('api')->user()->id)->with('book_relation')->get();
        // $data['category'] = BooksCategory::find($data['category_id'])['name'];
        // $data['locker'] = Locker::find($data['locker_id'])['name'] ?? '-';
        return response()->json(['error'=>false, 'message'=>'Success retrived data', 'data' => $data], 200);
        // $check_preference = Preference::where('user_id',Auth::guard('api')->user()->id)->first();
        // foreach($check_preference as $item)
        // {
        //     $data = Books::where('category_id',$item['category_id'])->paginate(6);
        //     // dd($check);
        //     return response()->json(['error'=>false, 'message'=>'Success retrived data', 'data' => $data], 200);
        // }
    }
    public function bookDetail($id){
        $data = Books::find($id);
        $wishlist_order = BooksOrder::where('user_id', Auth::guard('api')->user()->id)->where('wishlist',$data['examplar'])->first();
        $is_order = 0;
        $data_order = BooksOrder::where('user_id',Auth::guard('api')->user()->id)->where('status', 'FINISHED')->get();
        $is_order = count($data_order);
        $data['category'] = BooksCategory::find($data['category_id'])['name'];
        $data['locker'] = Locker::find($data['locker_id'])['name'] ?? '-';
        $data['komentar'] = Komentar::where('book_id',$id)->orderBy('created_at','DESC')->with('user_relation')->get();
        $data['like'] = Like::where('book_id',$id)->get()->count();
        $data['stock'] = Books::where('examplar',$data['examplar'])->where('ready',true)->get()->count();
        return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data, 'wishlisted' => $wishlist_order ? true : false, 'your_usage' => $is_order], 200);
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
