<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Contact;
use App\Models\Slide;
use Illuminate\Http\Request;
use DataTables;
use Dotenv\Validator;
use Carbon\Carbon;

class SettingsController extends Controller
{
    // SLIDE BANNER
    public function slideBanner(){
        $data = Slide::where('deleted_at',null)->get();
        return view('settings.slide-banner', compact('data'));
    }
    public function slideBannerPost(Request $request){
        $insert = $request->validate([
            'title' => 'required|unique:slide_banner,title,',
            'images' => 'required|image|mimes:jpg,png|max:2048|dimensions:min_width=800,min_height=300'
        ]);
        if($request->hasFile('images'))
        {
            $title = $request->title;
            $description = $request->description;
            $file = $request->images;
            $extension = time().'.'.$file->extension();
            // $extension = time().$file->getClientOriginalExtension();
            $file->move(public_path('slide'),$extension);
            $insert = new Slide();
            $insert->title = $title;
            $insert->description = $description;
            $insert->images = asset('slide/'.$extension);
            $insert->active = 1;
            if($insert->save())
                return redirect(route('slide-banner'))->with('success' , 'Berhasil menambahkan slide banner gambar' );
            return redirect(route('slide-banner'))->with('failed', 'Gagal menambahkan sldie banner gambar');
        }
    }
    public function slideDatatable(){
        $data = Slide::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('settings/slide-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('settings/'.$data['id'].'/slide-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editSlide" onclick="editSlide('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('active', function($data){
            return '<button class="btn btn-danger p-1 text-white">'.$data['active'].'</button>';
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action','active'])
        ->make(true);
    }
    public function slideEdit($id){
        $data = Slide::find($id);
        return view('settings.ajax-slide-banner',compact('data'));
    }
    public function slideDelete($id)
    {
        $data = Slide::find($id);
        if($data->delete());
            return redirect(route('slide-banner'))->with('success', 'Berhasil menghapus' .$data['name']);
        return redirect(route('slide-banner'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    public function slideEditExecute(Request $request){
        $data = $request->validate([
            'title' => 'required|max:30|min:2,'
        ]);
        $data = Slide::find($request->id);
        $data->title = $request->title;
        $data->description = $request->description;
        $data->active = $request->active;
        if($data->save())
            return redirect(route('slide-banner'))->with('success', 'Berhasil mengubah data slide banner' .$data['name']);
        return redirect(route('slide-banner'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    // CONTACT
    public function contact(){
        return view('settings.contact');
    }
    public function contactPost(Request $request)
    {
        if(!$request->all())
            return view('books-management.publisher');
        else{
            $insert = $request->validate([
                'description' => 'required'
            ]);
            $insert = Contact::create($request->all());
            if($insert)
                return redirect(route('contact'))->with('success' , 'Berhasil Menambahkan Kontak' );
            return redirect(route('contact'))->with('failed', 'Gagal Menamabhakan Kontak');
        }
    }
    public function contactDatatable()
    {
        $data = Contact::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('settings/contact-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('settings/'.$data['id'].'/contact-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editContactSchool" onclick="editContactSchool('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function contactEdit($id){
        $data = Contact::find($id);
        return view('settings.ajax-contact',compact('data'));
    }
    public function contactEditExecute (Request $request){
        $data = $request->validate([
            'description' => 'required'
        ]);
        $data = Contact::find($request->id);
        $data->description = $request->description;
        if($data->save())
            return redirect(route('contact'))->with('success', 'Berhasil mengubah data Kontak' .$data['name']);
        return redirect(route('contact'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    public function contactDelete($id){
        $data = Contact::find($id);
        if($data->delete());
            return redirect(route('contact'))->with('success', 'Berhasil menghapus' .$data['name']);
        return redirect(route('contact'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    // ABOUT
    public function about(){
        return view('settings.about');
    }
    public function aboutPost(Request $request)
    {
        if(!$request->all())
            return view('books-management.publisher');
        else{
            $insert = $request->validate([
                'description' => 'required'
            ]);
            $insert = About::create($request->all());
            if($insert)
                return redirect(route('about-school'))->with('success' , 'Berhasil Menambahkan Informasi' );
            return redirect(route('about-school'))->with('failed', 'Gagal Menamabhakan Informasi');
        }
    }
    public function aboutDatable(){
        $data = About::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return DataTables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('settings/about-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('settings/'.$data['id'].'/about-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editAboutSchool" onclick="editAboutSchool('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function aboutEdit($id)
    {
        $data = About::find($id);
        return view('settings.ajax-about',compact('data'));
    }
    public function aboutEditExecute(Request $request){
        $data = $request->validate([
            'description' => 'required'
        ]);
        $data = About::find($request->id);
        $data->description = $request->description;
        if($data->save())
            return redirect(route('about-school'))->with('success', 'Berhasil mengubah data Tentang Perpustakaan' .$data['name']);
        return redirect(route('about-school'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    public function aboutDelete($id){
        $data = About::find($id);
        if($data->delete());
            return redirect(route('about-school'))->with('success', 'Berhasil menghapus' .$data['name']);
        return redirect(route('about-school'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
}
