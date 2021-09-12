<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BooksCategory;
use App\Models\Author;
use App\Models\Publisher;
use App\Models\Edition;
use App\Models\Locker;
use DataTables;
use Dotenv\Validator;
use Carbon\Carbon;

class ManagemetBooksController extends Controller
{
    // Category
    public function category(){
        return view('books-management.category');
    }
    public function categoryCreate(Request $request){
        $data = BooksCategory::where('deleted_at',null)->get();
        if(!$request->all())
            return view('books-management.category');
        else{
            $insert = $request->validate([
                'name' => 'required|unique:book_category,name,'
            ]);
            $insert = BooksCategory::create($request->all());
            if($insert)
                return redirect(route('main-category-management'))->with('success', 'Berhasil menyimpan data kategori buku baru');
            return redirect(route('main-category-management'))->with('failed', 'Gagal menyimpan data kategori buku baru');
        }
    }
    public function categoryDatatable(){
        $data = BooksCategory::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('books-management/category-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/category-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editCategory" onclick="editCategory('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('jumlah_buku',function($data){
            return $data['jumlah_buku'];
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function categoryDelete($id){
        $data = BooksCategory::find($id);
        if($data->delete())
            return redirect(url('books-management/category'))->with('success', 'Berhasil menghapus data kategori buku' .$data['name']);
        return redirect(url('books-management/category'))->with('failed', 'Gagal menghapus data kategori buku' .$data['name']);
    }
    public function categoryEdit($id){
        $data = BooksCategory::find($id);
        return view('books-management.ajax-category-edit', compact('data'));
    }
    public function categoryEditExecute(Request $request){
        $data = $request->validate([
            'name' => 'required|max:30|min:2,'
        ]);
        $data = BooksCategory::find($request->id);
        $data->name = $request->name;
        if($data->save())
            return redirect(url('books-management/category'))->with('success','Berhasil mengubah kategori Buku ' .$data['name']);
        return redirect(url('books-management/'.$request->id.'/category'))->with('failed','Gagal mengubah kategori Buku' .$data['name']);
    }
    // Author
    public function author(){
        return view('books-management.author');
    }
    public function authorCreate(Request $request){
        $data = Author::where('deleted_at', null)->get();
        if(!$request->all())
            return view('books-management.author');
        else{
            $insert = $request->validate([
                'name' => 'required|unique:book_creator,name,'
            ]);
            $insert = Author::create($request->all());
            if($insert)
                return redirect(route('main-author-management'))->with('success' , 'Berhasil menyimpan data Penulis Buku' );
            return redirect(route('main-author-management'))->with('failed', 'Gagal menyimpan data Penulis Buku');
        }
    }
    public function authorDatatable(){
        $data = Author::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('books-management/author-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/author-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editAuthor" onclick="editAuthor('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function authorDelete($id){
        $data = Author::find($id);
        if($data->delete());
            return redirect(url('books-management/author'))->with('success', 'Berhasil menghapus data penulis buku' .$data['name']);
        return redirect(url('books-management/author'))->with('failed', 'Gagal menghapus data penulis buku' .$data['name']);
    }
    public function authorEdit($id){
        $data = Author::find($id);
        return view('books-management.ajax-author-edit', compact('data'));
    }
    public function authorEditExecute(Request $request){
        $data = $request->validate([
            'name' => 'required|max:30|min:2,'
        ]);
        $data = Author::find($request->id);
        $data->name = $request->name;
        if($data->save())
            return redirect(url('books-management/author'))->with('success','Berhasil mengubah data Penulis buku ' .$data['name']);
        return redirect(url('books-management/'.$request->id.'/author'))->with('failed','Gagal mengubah data Penulis buku' .$data['name']);
    }
    // Publisher
    public function publisher(){
        return view('books-management.publisher');
    }
    public function publisherCreate(Request $request){
        $data = Publisher::where('deleted_at', null)->get();
        if(!$request->all())
            return view('books-management.publisher');
        else{
            $insert = $request->validate([
                'name' => 'required|unique:book_publisher,name,'
            ]);
            $insert = Publisher::create($request->all());
            if($insert)
                return redirect(route('main-publisher-management'))->with('success' , 'Berhasil menyimpan data Penerbit Buku' );
            return redirect(route('main-publisher-management'))->with('failed', 'Gagal menyimpan data Penerbit Buku');
        }
    }
    public function publisherDatatable(){
        $data = Publisher::where('deleted_at',null)->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('books-management/publisher-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/publisher-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editPublisher" onclick="editPublisher('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);

    }
    public function publisherDelete($id){
        $data = Publisher::find($id);
        if($data->delete())
            return redirect(url('books-management/publisher'))->with('success', 'Berhasil menghapus data penerbit buku' .$data['name']);
        return redirect(url('books-management/publisher'))->with('failed', 'Gagal menghapus data penerbit buku' .$data['name']);
    }
    public function publisherEdit($id){
        $data = Publisher::find($id);
        return view('books-management.ajax-publisher-edit', compact('data'));
    }
    public function publisherEditExecute(Request $request){
        $data = $request->validate([
            'name' => 'required|max:30|min:2,'
        ]);
        $data = Publisher::find($request->id);
        $data->name = $request->name;
        if($data->save())
            return redirect(url('books-management/publisher'))->with('success','Berhasil mengubah data penerbit ' .$data['name']);
        return redirect(url('books-management/'.$request->id.'/publisher'))->with('failed','Gagal mengubah data Penerbit' .$data['name']);
    }
    // Edition
    public function edition(){
        return view('books-management.edition');
    }
    public function editionCreate(Request $request){
        $data = Edition::where('deleted_at',null)->get();
        if(!$request->all())
            return view('books-management.edition');
        else{
            $insert = $request->validate([
                'name' => 'required|unique:book_edition,name,'
            ]);
            $insert = Edition::create($request->all());
            if($insert)
                return redirect(route('main-edition-management'))->with('success', 'Berhasil menambahkan data edisi buku');
            return redirect(route('main-edition-management'))->with('failed', 'Gagal menambahkan data edisi buku');

        }

    }
    public function editionDatatable(){
        $data = Edition::where('deleted_at',null)->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('books-management/edition-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/edition-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editEdition" onclick="editEdition('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function editionDelete($id){
        $data = Edition::find($id);
        if($data->delete())
            return redirect(url('books-management/edition'))->with('success', 'Berhasil menghapus data edisi buku' .$data['name']);
        return redirect(url('books-management/edition'))->with('failed', 'Gagal menghapus data edisi buku' .$data['name']);
    }
    public function editionEdit($id){
        $data = Edition::find($id);
        return view('books-management.ajax-edition-edit', compact('data'));
    }
    public function editionEditExecute(Request $request){
        $data = $request->validate([
            'name' => 'required|max:30|min:2,'
        ]);
        $data = Edition::find($request->id);
        $data->name = $request->name;
        if($data->save())
            return redirect(url('books-management/edition'))->with('success','Berhasil mengubah data edisi buku ' .$data['name']);
        return redirect(url('books-management/'.$request->id.'/edition'))->with('failed','Gagal mengubah data edisi buku' .$data['name']);
    }
    // Locker
    public function locker(){
        return view('books-management.locker');
    }
    public function lockerCreate(Request $request){
        $data = Locker::where('deleted_at',null)->get();
        if(!$request->all())
            return view('books-management.locker');
        else{
            $insert = $request->validate([
                'name' => 'required|unique:book_locker,name,'
            ]);
            $insert = Locker::create($request->all());
            if($insert)
                return redirect(route('main-locker-management'))->with('success', 'Berhasil menyimpan data rak buku');
            return redirect(route('main-locker-management'))->with('failed', 'Gagal menyimpan data rak buku');

        }
    }
    public function lockerDelete($id){
        $data = Locker::find($id);
        if($data->delete())
            return redirect(url('books-management/locker'))->with('success', 'Berhasil menghapus data rak buku' .$data['name']);
        return redirect(url('books-management/locker'))->with('failed', 'Gagal menghapus data locker buku' .$data['name']);
    }
    public function lockerEdit($id){
        $data = Locker::find($id);
        return view('books-management.ajax-locker-edit', compact('data'));
    }
    public function lockerDatatable(){
        $data = Locker::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('books-management/locker-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/locker-edit')."'";

            $edit = '<button  key="'.$data['id'].'"  class="btn btn-info p-1 text-white" data-toggle="modal" data-target="#editLocker" onclick="editLocker('.$edit_link.')"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onclick="confirm_me('.$delete_message.','.$delete_link.')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function lockerEditExecute(Request $request){
        $data = $request->validate([
            'name' => 'required|max:30|min:2,'
        ]);
        $data = Locker::find($request->id);
        $data->name = $request->name;
        if($data->save())
            return redirect(url('books-management/locker'))->with('success','Berhasil mengubah data rak buku ' .$data['name']);
        return redirect(url('books-management/'.$request->id.'/locker'))->with('failed','Gagal mengubah data rak buku' .$data['name']);
    }
}
