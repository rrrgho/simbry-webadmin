<?php

namespace App\Http\Controllers;

use App\Models\BooksCategory;
use Illuminate\Http\Request;
use App\Models\Preference;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\returnSelf;

class PreferencsController extends Controller
{
    public function addPreference(Request $request)
    {
        $validated = $request->validate([
            'category_id' => ['required'],
        ]);
        $data = BooksCategory::where('id',$validated['category_id'])->first();
        if(!$data)
        {
            return response()->json(['error' => true, 'message' => 'Category not found!!']);
        }else{
            Preference::create([
                'user_id' => Auth::guard('api')->user()->id,
                'category_id' => $validated['category_id'],
            ]);
            if($data->save())
                return response()->json(['error' => false,'message' => 'Data preference berhasil di simpan'],200);
            return response()->json(['error' => true,'message' => 'Data preference gagal di simpan'],401);
        }
    }
    public function get_preference()
    {
        $data = Preference::where('deleted_at',null)->where('user_id',Auth::guard('api')->user()->id)->get();
        if($data)
            return response()->json(['error' => false, 'message' => 'Berhasil mengambil data preference', 'data' => $data],200);
        return response()->json(['error' => true, 'message' => 'Gagal mengambil data'],404);
    }
    public function category_buku()
    {
        // $check_data = Preference::where('user_id',Auth::guard('api')->user()->id)->get();
        // foreach($check_data as $item)
        // {
        //     return response()->json(['error' => false, 'message' => $item['category_id']],200);

        // }
        $data = BooksCategory::where('deleted_at',null)->get();
            return response()->json(['error' => false,'message' => 'Berhasil mengambil data category buku','data' => $data]);
        // $data = BooksCategory::where('id','<>',$item['category_id'])->get();
        // return response()->json(['error' => false, 'message' => $data],200);

    }
    public function categoryID($id)
    {
        $data = BooksCategory::find($id);
            return response()->json(['error' => false, 'message' => 'Berhasil Mengambil data','data' => $data]);
    }
}
