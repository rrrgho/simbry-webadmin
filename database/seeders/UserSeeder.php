<?php

namespace Database\Seeders;
use App\Models\History;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1; $i<=3; $i++)
            User::create([
                'user_number' => '000'.$i,
                'user_type_id' => $i,
                'password' => bcrypt('000'.$i),
                'name' => $i == 1 ? "Mahasiswa" : $i == 2 ? "Guru" : "Admin",
            ]);
    }
}
