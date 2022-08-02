<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Announcement;
use DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
class AnnouncementsController extends Controller
{
    public function announcement()
    {
        $data = Announcement::where('deleted_at',null)->get();
        return view('announcements.announcement',compact('data'));
    }
    public function announcement_add(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'images' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'required'
        ]);
        if($validator->fails()){
            return redirect()->back()->with('failed', [
                'status' => false,
                'message' => $validator->errors()->first()
            ]);
        }
        if($request->hasFile('images'))
        {
            $file = $request->file('images');
            $fileName = $file->getClientOriginalName();
            $resize = Image::make($file);
            $resize->resize(1200,630);
            if (!in_array($request->file('images')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            $resize->save(public_path('announcement/'.$request->title.'BIMG-'.$file->getClientOriginalName()));;
            $pathAnnoun = asset('announcement/'.$request->title.'BIMG-'.$file->getClientOriginalName());
        }
        $insert = Announcement::create([
            'name' => $request->name,
            'description' => $request->description,
            'images' => $pathAnnoun,
        ]);
        if($insert)
            return redirect()->back()->with('success', ['status' => false,'message' => 'Berhasil menambahkan pengumuman infromasi']);
        return redirect()->back()->with('failed', ['status' => false,'message' => 'Gagal menambahkan pengumuman informasi']);
    }
    public function annountcementDatatable()
    {
        $data = Announcement::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('announcement-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('announcement-edit/'.$data['id'])."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editAnnouncements" onclick="editAnnouncements('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function announcementEdit($id)
    {
        $data = Announcement::find($id);
        return view('announcements.ajax',compact('data'));
    }
    public function announcementEditExecute(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|max:30|min:2,'
        ]);
        if($request->hasFile('images'))
        {
            $file = $request->file('images');
            $fileName = $file->getClientOriginalName();
            $resize = Image::make($file);
            $resize->resize(1200,630);
            if (!in_array($request->file('images')->getClientOriginalExtension(), array('jpg', 'jpeg', 'png'))) return response()->json(['error' => true, 'message' => 'File type is not supported, support only JPG, JPEG and PNG !'], 200);
            $resize->save(public_path('announcement/'.$request->title.'BIMG-'.$file->getClientOriginalName()));;
            $pathAnnoun = asset('announcement/'.$request->title.'BIMG-'.$file->getClientOriginalName());
        }
        return $pathAnnoun;
        $data = Announcement::find($request->id);
        $data->name = $request->name;
        $data->description = $request->description;
        $data->images = $pathAnnoun;
        if($data->save())
            return redirect(route('announcements'))->with('success', 'Berhasil mengubah data pengumuman' .$data['name']);
        return redirect(url('announcements'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    public function announcementDelete($id)
    {
        $data = Announcement::find($id);
        if($data->delete());
            return redirect(route('announcements'))->with('success', 'Berhasil menghapus' .$data['name']);
        return redirect(url('announcements'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
}
