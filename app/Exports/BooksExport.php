<?php

namespace App\Exports;

use App\Models\Books;
use Maatwebsite\Excel\Concerns\FromCollection;

class BooksExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Books::all();
    }
}
