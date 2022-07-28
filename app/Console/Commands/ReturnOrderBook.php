<?php

namespace App\Console\Commands;

use App\Models\Books;
use App\Models\BooksOrder;
use Carbon\Carbon;
use Illuminate\Console\Command;

class ReturnOrderBook extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'book:order';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mengembalikan peminjaman yang tidak di approve selama 2 hari by: TubagusDev';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $data = BooksOrder::where([
            ['deleted_at',null],
            ['status','PENDING'],
            ['end_date','<',Carbon::now('Asia/Jakarta')]
        ])->orderBy('created_at','DESC')->get();
        if($data){
            foreach($data as $item){
                $querybook = Books::find($item->book_id);
                $querybook->ready = 1;
                $querybook->save();
                $query = BooksOrder::find($item->id);
                $query->delete();
            }
            info("SUCCESS");
        }else{
            info("GAGAL");
        }
        // info($dataEnd->diffInDays(Carbon::now('Asia/Jakarta')));
    }
}
