<?php

namespace App\Exports;

use App\Models\Books;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class LaporanExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $year = Carbon::now()->format('Y');
        return DB::table('book')
        ->whereYear('created_at', '=', $year)
        ->get();
    }
}
