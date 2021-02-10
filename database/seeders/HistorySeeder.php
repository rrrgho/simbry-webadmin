<?php

namespace Database\Seeders;
use App\Models\History;
use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        History::create([
            'user_id' => '10003',
            'book_id' => '100012223',
            'status' => 'Success',
        ]);
    }
}
