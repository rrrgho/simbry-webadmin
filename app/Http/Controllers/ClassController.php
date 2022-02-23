<?php

namespace App\Http\Controllers;

use App\Models\BooksOrder;
use Illuminate\Http\Request;

// Call Service
use DataTables;
use Carbon\Carbon;

// Call Model
use App\Models\User;
use App\Models\ClassModel;
use App\Models\Popular;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class ClassController extends Controller
{
    public function index(){
        $teacher = User::where('deleted_at',null)->where('user_type_id',2)->get();
        $unit = Unit::all();
        return view('class-management.index', compact('teacher','unit'));
    }
    public function StudentTerpopuler()
    {
        $sd = User::where('deleted_at',null)->where('unit',1)->where('point','>',0)->orderBy('point','DESC')->take(5)->get();
        $smp =  User::where('deleted_at',null)->where('unit',2)->where('point','>',0)->orderBy('point','DESC')->take(5)->get();
        $smk = User::where('deleted_at',null)->where('unit',3)->where('point','>',0)->orderBy('point','DESC')->take(5)->get();
        $sma = User::where('deleted_at',null)->where('unit',4)->where('point','>',0)->orderBy('point','DESC')->take(5)->get();
        $popular = Popular::where('status',true)->whereMonth('created_at',Carbon::now('Asia/Jakarta')->month)->get();
        return view('class-management.student-terpopuler', compact('sd','smp','sma','smk','popular'));
    }
    public function StudentPublish(Request $request)
    {
        // return $request->all();
        $insert = $request->validate([
            'user_id' => 'required',
            'unit_id' => 'required',
        ]);
        $insert = Popular::create($request->all());
        if($insert)
            return redirect(route('student-terpopuler'))->with('success', 'Berhasil Mempublish Siswa');
        return redirect(route('student-terpopuler'))->with('failed', 'Berhasil Mempublish Siswa');
    }
    public function ResetPoint(Request $request)
    {
        $user = User::query()->update(['point' => 0]);
        if($user)
            return redirect(route('student-terpopuler'))->with('success', 'Berhasil Reset Point');
        return redirect(route('student-terpopuler'))->with('failed', 'Gagal Reset point');
    }
    public function allReset(Request $request)
    {
        $password_new = $request->password;
        $user = User::query()->update(['password' => bcrypt($password_new)]);
        if($user)
            return "Berhasil Ganti Password";
        // if($user)
        //     return redirect(route('main-class-management'))->with('success','Berhasil Ganti Password User');
        // return redirect(route('main-class-management'))->with('failed','Gagal Ganti Password User');
    }
    public function ResetPassword(Request $request){

    }
    public function detailSiswa($id)
    {
        $data = User::where('id', $id)->where('deleted_at',null)->get();
        // $order = BooksOrder::where('user_id', $id)->where('status','APPROVED')->get();
        return view('class-management.student-detail',compact('data'));
    }
    public function detailSiswaExecute(Request $request){
        $data = $request->validate([
            'user_number' => 'required',
            'name' => 'required'
        ]);
        $data = User::find($request->id);
        $data->user_number = $request->user_number;
        $data->name = $request->name;
        $data->password = Hash::make($request->password);
        if($data->save())
            return redirect(route('main-class-management'))->with('success', 'Berhasil mengubah data Kontak' .$data['name']);
        return redirect(route('main-class-management'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    public function detailGuru($id)
    {
        $data = User::where('id', $id)->where('deleted_at',null)->get();
        // $order = BooksOrder::where('user_id', $id)->where('status','APPROVED')->get();
        return view('class-management.teacher-detail',compact('data'));
    }
    public function detailGuruExecute(Request $request){
        $data = $request->validate([
            'user_number' => 'required',
            'name' => 'required'
        ]);
        $data = User::find($request->id);
        $data->user_number = $request->user_number;
        $data->name = $request->name;
        $data->password = Hash::make($request->password);
        if($data->save())
            return redirect(route('main-teacher-management'))->with('success', 'Berhasil mengubah data Kontak' .$data['name']);
        return redirect(route('main-teacher-management'))->with('failed', 'Gagal menghapus' .$data['name']);
    }
    public function teacher(){
        return view('class-management.teacher');
    }
    public function migrasiClass ()
    {
        $class = ClassModel::where('deleted_at',null)->get();
        $user = User::where('deleted_at',null)->get();
        return view('class-management.migrasi', compact('user','class'));
    }
    // Teacher Datatable
    public function teacherDatatable(){
        $data = User::where('deleted_at',null)->orderBy('created_at','DESC')->where('user_type_id',2)->get();

        return Datatables::of($data)
        ->addIndexColumn()
        ->addColumn('action', function($data){
            $delete_link = "'".url('class-management/teacher-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/category-edit')."'";
            $editDetail = '<a href="'.route('detail-guru', [$data['id']]).'" class="btn btn-info p-1 text-white" id="btn-edit"> <i class="fa fa-sign-out"> </i> </a>';
            $edit = '<button  key="'.$data['id'].'" data-toggle="modal" data-target="#addTeacher"  class="btn btn-info p-1 text-white" onclick="getEditTeacherComponent('.$data['id'].')" id="btn-edit"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onClick="deleteTeacherData('.$data['id'].')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete.''.$editDetail;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    // Student Datatable
    public function studentDatatable(){
        $data = User::query()->where('deleted_at',null)->orderBy('created_at','DESC')->where('user_type_id',1);

        return Datatables::eloquent($data)
        ->addColumn('action', function($data){
            $delete_link = "'".url('books-management/category-delete/'.$data['id'])."'";
            $delete_message = "'This cannot be undo'";
            $edit_link = "'".url('books-management/'.$data['id'].'/category-edit')."'";
            $editDetail = '<a href="'.route('detail-siswa', [$data['id']]).'" class="btn btn-info p-1 text-white" id="btn-edit"> <i class="fa fa-sign-out"> </i> </a>';
            $edit = '<button  key="'.$data['id'].'" data-toggle="modal" data-target="#addStudent"  class="btn btn-info p-1 text-white" onclick="getEditStudentComponent('.$data['id'].')" id="btn-edit"> <i class="fa fa-edit"> </i> </button>';
            $delete = '<button onClick="deleteStudentData('.$data['id'].')" class="btn btn-danger p-1 text-white"> <i class="fa fa-trash"> </i> </button>';
            return $edit.' '.$delete.''.$editDetail;
        })
        ->addColumn('created_at', function($data){
            return Carbon::parse($data['created_at'])->format('F d, y');
        })
        ->addColumn('class_id', function($data){
            return $data->class_relation['name'];
        })
        ->rawColumns(['action'])
        ->make(true);
    }
    public function addStudent(Request $request){
        $requestData = $request->all();
        $class_user = ClassModel::find($request->class_id)['unit_id'];
        $unit_id = Unit::find($class_user)['name'];
        $requestData['name'] = $request->name;
        $requestData['user_number'] = $unit_id."SIM".$request->user_number;
        $requestData['user_type_id'] = 1;
        $requestData['password'] = bcrypt($request->password);
        $requestData['unit'] = $class_user;
        $insert = User::create($requestData);
        if($insert)
            return response()->json(['error' => false, 'message' => 'Berhasil menambahkan Siswa '.$request->name], 200);
        return response()->json(['error' => true, 'message' => 'Gagal menambahkan kelas'], 200);
    }
    public function editStudent(Request $request){  
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->class_id = $request->class_id;
        $user->user_number = $request->user_number;
        if($user->save())
            return response()->json(['error' => false, 'message' => 'Berhasil mengubah data Siswa '.$request->name], 200);
        return response()->json(['error' => true, 'message' => 'Gagal mengubah data kelas'], 200);
    }
    public function deleteStudent(Request $request){
        $user = User::find($request->id);
        if($user->delete())
            return response()->json(['error' => false, 'message' => 'Berhasil menghapus data Siswa '.$user->name], 200);
        return response()->json(['error' => true, 'message' => 'Gagal menghapus data siswa'], 200);
    }
    public function upgradeSiswa(Request $request){
        $class = ClassModel::where('deleted_at',null)->get();
        // dd($class);
        if(!$request->all())
            return view('class-management.upgrade-siswa', compact('class'));
        $data = User::where('class_id',$request->class_id)->where('deleted_at',null)->get();
        return view('class-management.upgrade-siswa', compact('class','data'));
    }
    public function moveClass(Request $request){
       $data = $request->user_id;
        foreach($data as $item){
            // return $data;
            $query = User::find($item);
            $query->class_id = $request->class_id;
            // dd($query);
            $query->save();
        }
       return redirect(route('main-upgrade-siswa'))->with('success','Berhasil mengupgrade siswa, silahkan liat data siswa di menu data siswa');
    }
    public function deleteSiswa(Request $request)
    {
        $data = $request->user_id;
        foreach($data as $item){
            $query = User::find($item);
            // $query->class_id = $request->class_id;
            $query->delete();
        }
        return redirect(route('main-upgrade-siswa'))->with('success','Berhasil mengupgrade siswa, silahkan liat data siswa di menu data siswa');
    }


    // Teacher
    public function addTeacher(Request $request){
        $requestData = $request->all();
        $check_teacher = User::where('user_number',$request->user_number)->first();
        if($check_teacher)
        {
            return response()->json(['error' => true, 'message' => 'User number already exist!!'], 401);
        }else{

            $requestData['user_type_id'] = 2;
            $requestData['password'] = bcrypt($request->password);
            $insert = User::create($requestData);
            if($insert)
                return response()->json(['error' => false, 'message' => 'Berhasil menambahkan guru ' .$request->name], 200);
            return response()->json(['error' => true, 'message' => 'Gagal menambahkan guru'], 401);
        }
    }
    public function editTeacher(Request $request){
        $user = User::find($request->id);
        $user->name = $request->name;
        $user->user_number = $request->user_number;
        if($user->save())
            return response()->json(['error' => false, 'message' => 'Berhasil mengubah data Guru '.$request->name], 200);
        return response()->json(['error' => true, 'message' => 'Gagal mengubah data Guru'], 200);
    }
    public function deleteTeacher(Request $request){
        $user = User::find($request->id);
        if($user->delete())
            return response()->json(['error' => false, 'message' => 'Berhasil menghapus data Guru '.$user->name], 200);
        return response()->json(['error' => true, 'message' => 'Gagal menghapus data Guru'], 200);
    }



    // Class
    public function addClass(Request $request){
        $insert = ClassModel::create($request->all());
        if($insert)
            return response()->json(['error' => false, 'message' => 'Berhasil menambahkan kelas'], 200);
        return response()->json(['error' => true, 'message' => 'Gagal menambahkan kelas'], 200);

    }

    // Component by AJAX
    public function componentAddStudent(){
        $class = ClassModel::where('deleted_at',null)->orderBy('created_at','DESC')->get();
        return view('class-management.component-add-student', compact('class'));
    }
    public function componentAddTeacher(){
        return view('class-management.component-add-teacher');
    }
    public function componentEditStudent(Request $request){
        $class = ClassModel::where('deleted_at',null)->get();
        $user = User::find($request->id);
        return view('class-management.component-edit-student', compact('class','user'));
    }
    public function componentEditTeacher(Request $request){
        $user = User::find($request->id);
        return view('class-management.component-edit-teacher', compact('user'));
    }
    public function componentStudentDatatable(){
        return view('class-management.component-student-datatable');
    }
    public function componentTeacherDatatable(){
        return view('class-management.component-teacher-datatable');
    }
}
