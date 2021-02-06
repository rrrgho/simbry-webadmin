<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RuleOrder;

class RuleOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        for($i=1; $i<=2; $i++){
            RuleOrder::create([
                'user_type' => $i,
                'limit' => $i == 1 ? 2 : 3,
            ]);
        }
    }
}
