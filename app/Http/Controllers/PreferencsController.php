<?php

namespace App\Http\Controllers;

use App\Models\BooksCategory;
use Illuminate\Http\Request;
use App\Models\Preference;
use App\Models\Preferensi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use DataTables;
use Carbon\Carbon;
use Yajra\DataTables\Contracts\DataTable;

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
            $insert = new Preference();
            $insert->user_id = Auth::guard('api')->user()->id;
            $insert->category_id = $validated['category_id'];
            $insert->save();
            if($data->save())
                return response()->json(['error' => false,'message' => 'Data preference berhasil di simpan', 'id' => $insert->id],200);
            return response()->json(['error' => true,'message' => 'Data preference gagal di simpan'],401);
        }
    }
    public function delete_preference(Request $request)
    {
        $validated = $request->validate([
            'id_preference' => ['required'],
        ]);
        $data = Preference::find($validated['id_preference']);
        if($data->delete())
            return response()->json(['error' => false, 'message' => 'Berhasil mendelete data preference'],200);
        return response()->json(['error' => true, 'message' => 'Gagal mendelete data preference'],401);

    }
    public function get_preference()
    {
        $data = Preference::where('deleted_at',null)->where('user_id',Auth::guard('api')->user()->id)->with('Category')->get();
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
    public function preferensi(){
        $data = Preferensi::all();
        return view('preferensi.index', compact('data'));
    }
    public function getPrefernsi()
    {
        $data = Preferensi::where('deleted_at',null)->get();
            return response()->json(['error' => false,'message' => 'Success get data','data' => $data]);
    }
    public function preferensiDataTable()
    {
        $data = Preferensi::orderBy('created_at','DESC')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->make(true);
    }
    public function addPreferensi(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'user_id' => 'required',
            'category_id' => 'required',
            'name' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $insert = Preferensi::create([
            'user_id' => Auth::guard('api')->user()->id,
            'judul' => $request->judul,
            'description' => $request->description,
        ]);
        if($insert)
            return response()->json(['error' => false,'message' => 'Kamu berhasil memberi preferensi kepada admin','data' => $insert],200);
        return response()->json(['error' => true,'message' => 'Kamu gagal memberi preferensi kepada admin'],400);
    }
}
