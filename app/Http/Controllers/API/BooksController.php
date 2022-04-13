<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Call Model
use App\Models\Books;
use App\Models\BooksCategory;
use App\Models\BooksOrder;
use App\Models\EBooks;
use App\Models\Komentar;
use App\Models\Like;
use App\Models\Locker;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\Foreach_;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Intervention\Image\Facades\Image;
use File;
use Illuminate\Support\Facades\Validator;

class BooksController extends Controller
{
    public function eBooksData()
    {
        $data = EBooks::orderBy('created_at', 'DESC')->paginate(6);
        foreach($data as $item){
            $item['publisher_id'] = "";
            $item['publisher_id'] = "";
            $item['locker_id'] = "";
            $item['book_number'] = "";
            $item['queue_of_examplar'] = "";
            $item['examplar'] = "";
            $item['code_of_book'] = "";
            $item['call_number'] = "";
            $item['ready'] = "";
            $item['borrowed'] = "";
            $item['no_panggil'] = "";
        }
        return $data;
    }
    public function eBooksDetail($id)
    {
        $data = EBooks::find($id);
        $data['category'] = BooksCategory::find($data['category_id'])['name'];
        $data['publisher_id'] = "";
        $data['publisher_id'] = "";
        $data['locker_id'] = "";
        $data['book_number'] = "";
        $data['queue_of_examplar'] = "";
        $data['examplar'] = "";
        $data['code_of_book'] = "";
        $data['call_number'] = "";
        $data['ready'] = "";
        $data['borrowed'] = "";
        $data['no_panggil'] = "";
        return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data, 'wishlisted' => "", 'your_usage' => "",'is_borrowing' => ""], 200);
    }
    public function ocrBooks(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        $image = $request->image;
        $imagePath = Storage::disk('public')->put('ocr',$image);
        $file = public_path("storage/$imagePath");
        $teaserOcr = new TesseractOCR($file);
        $text = $teaserOcr->run();
        if($text)
            File::delete($file);
        return response()->json(['error' => false,'message' => 'Berhasil mendapatkan data','data' => $text],200);
        
    }
    public function bookData(){
        // $data = Books::paginate(6);
        $data = Books::orderBy('created_at', 'DESC')->paginate(6);
        // $data['locker'] = Locker::find($data['locker_id'])['name'] ?? '-';
        return response()->json(['error'=>false, 'message'=>'Success retrived data', 'data' => $data], 200);
    }
    // public function getBookbyPreference(Request $request)
    // {
    //     $category_req = $request->category_req;
    //     $sub_category_req = $request->sub_category;
    
    //     $check_user = Auth::guard('api')->user()->unit_name;
    //     // dd($check_user);
    //     $preferences = Preference::where('user_id', Auth::guard('api')->user()->id)->get();
    //     if($check_user == 'TK')
    //     {
    //         $check_categoryTK = BooksCategory::where('name','TK')->first();
    //         if($preferences == '[]'){
    //             if($category_req == NULL && $sub_category_req == NULL)
    //             {
    //                 return Books::where('category_id',$check_categoryTK->id)->orderBy('created_at', 'DESC')->paginate(6);
    //             }
    //         }else{
    //             return Books::where('category_id',$check_categoryTK->id)->orderBy('created_at', 'DESC')->paginate(6);
    //         }
    //     }else{
    //         if($preferences == '[]'){
    //             if($category_req == NULL && $sub_category_req == NULL)
    //             {
    //                 return Books::orderBy('created_at', 'DESC')->paginate(6);
    //             }else if($category_req !== NULL && $sub_category_req == NULL){
    //                 return Books::where('category_id',$category_req)->orderBy('created_at', 'DESC')->paginate(6);
    //             }else{
    //                 return Books::where('category_id',$category_req)->where('sub_category',$sub_category_req)->orderBy('created_at', 'DESC')->paginate(6);
    //             }
    //         }else{
    //             $query = [
    //                 ['category_id', $preferences[0]['category_id']]
    //             ];
    //             $i=0;
    //             foreach( $preferences as $preference){
    //                 if($i!=0)
    //                 $query[] = ['category_id', $preference['category_id']];
    //                 $i++;
    //             }
    //             // return $query;
    //             return Books::where([
    //             [
    //                 "category_id",
    //                 $preferences[0]['category_id']
    //             ],
    //             ])
    //             ->orWhere($query)
    //             ->paginate(6);
    //         }
    //     }
    // }
    public function getBookbyPreference(Request $request)
    {
        $check_user = Auth::guard('api')->user()->unit_name;
        $preferences = Preference::where('user_id', Auth::guard('api')->user()->id)->get();
        if($check_user == 'TK')
        {
            $check_categoryTK = BooksCategory::where('name','TK')->first();
            if($preferences == '[]')
                return Books::where('category_id',$check_categoryTK->id)->orderBy('created_at', 'DESC')->paginate(6);
        }else{
            if($preferences == '[]'){
                return Books::orderBy('created_at', 'DESC')->paginate(6);
            }else{
                $query = [
                    ['category_id', $preferences[0]['category_id']]
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
        }
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
        $data_order = BooksOrder::where('user_id',Auth::guard('api')->user()->id)->where('book_id',$id)->where('status', 'FINISHED')->get();
        $is_order = count($data_order);
        $check_user_wishlist = BooksOrder::where('user_id',Auth::guard('api')->user()->id)->where('book_id',$id)->where('status','WISHLIST')->first();
        // return $check_user_wishlist ? "ada" : "tidak";
        $data['category'] = BooksCategory::find($data['category_id'])['name'];
        $data['book_number'] = $data['book_number'].' | NP '.$data['no_panggil'];
        $data['locker'] = Locker::find($data['locker_id'])['name'] ?? '-';
        $data['komentar'] = Komentar::where('book_id',$id)->orderBy('created_at','DESC')->with('user_relation')->get();
        $data['like'] = Like::where('book_id',$id)->get()->count();
        $data['stock'] = Books::where('examplar',$data['examplar'])->where('ready',true)->get()->count();
        if($data['ready'] == 0)
            return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data, 'wishlisted' => $wishlist_order ? true : false, 'your_usage' => $is_order,'is_borrowing' => $check_user_wishlist ? true : false], 200);
        return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data, 'wishlisted' => $wishlist_order ? true : false, 'your_usage' => $is_order,'is_borrowing' => false], 200);
        
    }
    public function bookSearch(Request $request){
        $data = Books::where('name', 'like', '%' . $request->judul . '%')->orderBy('created_at','DESC')->paginate(6);
        return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data], 200);
    }
    public function EbookSearch(Request $request){
        $data = EBooks::where('name', 'like', '%' . $request->judul . '%')->paginate(6);
        return response()->json(['error' => false, 'message' => 'Success get data', 'data' => $data], 200);
    }
    public function bookSearchWeb(Request $request){
        $data = Books::where('name', 'like', '%' . $request->judul . '%')->paginate(6);
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
