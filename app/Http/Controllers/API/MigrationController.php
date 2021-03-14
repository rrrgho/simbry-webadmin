<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\OldBook;
use App\Models\OldStudent;
use App\Models\BooksCategory;
use App\Models\Publisher;
use App\Models\Books;
use App\Models\Migrated;
use App\Models\Unit;
use App\Models\User;
use App\Models\ClassModel;
use Session;

class MigrationController extends Controller
{
    public function __construct()
    {
        set_time_limit(800000000000000);
    }
    // Migrate Book Category
    public function migrateBookCategory(){
        $oldBook = OldBook::all();
        foreach($oldBook as $book){
            $exist = BooksCategory::where('name', $book->kategori)->first();
            if(!$exist)
                BooksCategory::create(['name' => $book->kategori]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate book category has been finished'], 200);
    }

    // Add unit id to user
    public function add_unit_id(){
        $data = User::where('class_id','<>',null)->get();
        foreach($data as $item){
            $class = ClassModel::find($item['class_id'])['unit_id'];
            $item->unit = $class;
            $item->save();
        }
    }


    // Migrate Book Publisher
    public function migrateBookPublisher(){
        $oldBook = OldBook::all();
        foreach($oldBook as $book){
            $exist = Publisher::where('name', $book->penerbit)->first();
            if(!$exist)
                Publisher::create(['name' => $book->penerbit]);
        }
        return response()->json(['error' => false, 'message' => 'Migrate book publisher has been finished'], 200);
    }

    // Migrate Book
    public function migrateBook(){
        // Migrate Book Number
        // return count(Books::all());
        // return $books = Books::where('year_in','>=',20)->where('year_in','<=',80)->orderBy('year_in','ASC')->get();
        // $queue = Migrated::find(3);
        // $ordered = $queue['value'];
        // $number = "";
        // foreach($books as $item){
        //     for($i=1; $i<=6-strlen($ordered); $i++){
        //         $number.="0";
        //     }
        //     $number.=strval($ordered);
        //     $item->book_number = $number.'-20'.$item->year_in;
        //     $item->year_in = '20'.$item->year_in;
        //     $item->save();
        //     $ordered++;
        //     $number="";
        // }
        // $queue->value = $ordered;
        // $queue->save();
        // return $ordered;

        
        // $migrated = Migrated::find(1);
        // $oldBook = OldBook::select(['judul','id','noinduk','kategori','penerbit'])->where('noinduk','<>','')->where('visible','true')->where('id','>=',$migrated['value'])->where('id','<=',$migrated['value']+2000)->orderBy('id','ASC')->get();
        // $nomor = "";
        // $looped = 0;
        // $inserted = 0;
        // foreach($oldBook as $book){
        //     if(!Books::where('name', $book->judul)->first()){
        //         $examplar = "";
        //         $queue_copy = !Books::max('queue_of_examplar') ? 1 : Books::max('queue_of_examplar') + 1;
        //         if(strlen($examplar) < 1){
        //             for($j=1; $j<7 - strlen(strval($queue_copy)); $j++){
        //                 $examplar .= "0";
        //             }
        //             $examplar.=strval($queue_copy);
        //         }
        //         $sameTitle = OldBook::where('judul', $book->judul)->where('visible','true')->get();
        //         for($i=0; $i<count($sameTitle); $i++){
        //             $index = count(Books::all()) == 0 ? 1 : count(Books::all()) + 1;
        //             $category = BooksCategory::where('name', $book['kategori'])->first()['id'];
        //             $publisher = Publisher::where('name', $book['penerbit'])->first()['id'];
        //             $year = substr($sameTitle[$i]['noinduk'],strlen($sameTitle[$i]['noinduk'])-2);
        //             for($k=1; $k<=6 - strlen(strval($index)); $k++){
        //                 $nomor .= "0";
        //             }
        //             $nomor.=strval($index).strval($year);
        //             $copy = count(Books::where('examplar',$examplar)->get()) == 0 ? 1 : count(Books::where('examplar',$examplar)->get()) + 1;
        //             $examplar_number = $examplar.'/'.Carbon::now('Asia/Jakarta')->year.'/C'.$copy.'of'.count($sameTitle);
        //             $insert = Books::create([
        //                 'name' => $book->judul,
        //                 'category_id' => $category,
        //                 'publisher_id' => $publisher,
        //                 'edition' => $sameTitle[$i]['edisi'],
        //                 'locker_id' => null,
        //                 'origin_book' => $sameTitle[$i]['asal'] ?? null,
        //                 'creator' => $sameTitle[$i]['penulis'] ?? null,
        //                 'publish_year' => strlen($sameTitle[$i]['tahun']) == 4 ? $sameTitle[$i]['tahun'] : null,
        //                 'buying_year' => strlen($sameTitle[$i]['tahunbeli']) == 4 ? $sameTitle[$i]['tahunbeli'] : null,
        //                 'book_number' => null,
        //                 'year_in' => intval($year) ?? null,
        //                 'queue_of_examplar' => $queue_copy,
        //                 'examplar' => $examplar,
        //                 'code_of_book' => $examplar_number,
        //                 'call_number' => $examplar.'-'.$index,
        //                 'description' => $sameTitle[$i]['edition'] ?? null,
        //             ]);
        //             if($insert){
        //                 $nomor = "";
        //                 $looped++;
        //                 $inserted++;
        //                 $sameTitle[$i]->visible = 'delete';
        //                 $sameTitle[$i]->save();

        //             }
        //         }$examplar = ""; 
        //         $looped++;  
        //     }
        // }
        // $migrated->value = $migrated['value']+2000;
        // $migrated->save();
        
        // $migrated2 = Migrated::find(2);
        // $dataMasuk = $migrated2['value'];
        // $migrated2->value = $dataMasuk + $inserted;
        // $migrated2->save();
        // return "Has Looped about : " .$looped. " Has inserted about :" . $inserted;
    }

    // Migrate Book Number
    public function migrateBookNumber(){
        $oldBook = Books::where('publish_year',null)->get();
        $i=Books::max('year_in');
        $nomor = "";
        foreach($oldBook as $book){
            if(strlen($nomor) < 1){
                for($j=1; $j<6 - strlen(strval($i)); $j++){
                    $nomor .= "0";
                }
                $nomor.=strval($i);
            }
            $year = '-20';
            $book->year_in = $nomor;
            $nomor.=$year;
            $book->book_number = $nomor;
            $book->save();


            $i++;
            $nomor="";
        }
    }


    // Migrate Class Unit
    public function migrateClassUnit(){
        $oldData = OldStudent::all();

        // Migrate Unit
        // foreach($oldData as $data){
        //     $exist = Unit::where('name', $data['unit'])->first();
        //     if(!$exist)
        //         Unit::create([
        //             'name' => $data['unit'],
        //         ]);
        // }

        // Migrate Class
        // foreach($oldData as $data){
        //     $exist = ClassModel::where('name',$data['kelas'])->first();
        //     if(!$exist){
        //         $id_unit = Unit::where('name', $data['unit'])->first()['id'];
        //         ClassModel::create([
        //             'unit_id' => $id_unit,
        //             'name' => $data['kelas'],
        //         ]);
        //     }
        // };


        // Migrate Student
        // foreach($oldData as $data){
        //     $exist = User::where('user_number', $data['nis'])->first();
        //     if(!$exist){
        //         $class_id = ClassModel::where('name', $data['kelas'])->first()['id'];
        //         User::create([
        //             'user_number' => $data['nis'],
        //             'class_id' => $class_id,
        //             'user_type_id' => 1,
        //             'name' => $data['nama'],
        //             'password' => bcrypt($data['nis']),
        //         ]);
        //     }
        // }
        // return "selesai";
    }
}
