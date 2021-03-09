<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\GameLevel;
class GameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name = ['BRONZE','SILVER','GOLD','PLATINUM'];
        $range = [0,10,20,30];
        for($i=0; $i<count($name); $i++){
            GameLevel::create([
                'name' => $name[$i],
                'amount' => $range[$i],
            ]);
        }
    }
}
