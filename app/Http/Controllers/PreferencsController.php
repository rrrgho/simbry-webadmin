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
        $data = Preferensi::where('status',1)->get();
        return view('preferensi.index', compact('data'));
    }
    public function preferensiEdit($id)
    {
        $data = Preference::find($id);
        return view('preferensi.ajax-preferensi',compact('data'));
    }
    public function getPrefernsi()
    {
        $data = Preferensi::where('user_id',Auth::guard('api')->user()->id)->where('deleted_at',null)->orderBy('created_at','DESC')->get();
        if($data == '[]')
            return response()->json(['error' => true,'message' => 'Data not Found!!','data' => $data]);
        return response()->json(['error' => false,'message' => 'Success get data','data' => $data,'isStatus' => $data[0]->status == 1 ? true : false]);
    }
    public function preferensiDataTable()
    {
        $data = Preferensi::orderBy('created_at','DESC')->get();
        // return $data;
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('status',function($data){
            $result = $data['status'] == 1 ? 'PENDING' : 'APPROVE';
            if($result == 'PENDING')
                return '<button class="btn btn-success p-1 text-white">'.$result.'</button>';
            return '<button class="btn btn-danger p-1 text-white">'.$result.'</button>';
        })
        ->addColumn('action', function($data){
            $edit_link = "'".url('/'.$data['id'].'/preferensi-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editPreferensi" onclick="editPreferensi('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            return $edit;
        })
        ->rawColumns(['status','action'])
        ->make(true);
    }
    public function preferensiEditExecute(Request $request){
        $data = Preferensi::find($request->id);
        $data->status = $request->status;
        if($data->save())
            return redirect(route('main-preferensi'))->with('success', 'Berhasil mengubah data slide banner' .$data['name']);
        return redirect(route('main-preferensi'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    public function addPreferensi(Request $request)
    {
        $validated = Validator::make($request->all(),[
            'judul' => 'required',
        ]);
        if($validated->fails())
        {
            return response()->json(['error' => true,'message' => $validated->errors()],400);
        }
        $insert = Preferensi::create([
            'user_id' => Auth::guard('api')->user()->id,
            'judul' => $request->judul,
            'status' => 1,
            'description' => $request->description,
        ]);
        if($insert)
            return response()->json(['error' => false,'message' => 'Kamu berhasil memberi preferensi kepada admin','data' => $insert],200);
        return response()->json(['error' => true,'message' => 'Kamu gagal memberi preferensi kepada admin'],400);
    }
}
