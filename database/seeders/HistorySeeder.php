<?php

namespace Database\Seeders;
use App\Models\History;
use Illuminate\Database\Seeder;
use App\Models\User;

class HistorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'user_number' => '10003',
            'user_type_id' => '2',
            'password' => 'Medan1010',
        ]);
    }
}
