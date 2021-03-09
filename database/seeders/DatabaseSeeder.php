<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            // UserSeeder::class,
            GameSeeder::class
        ]);
        // $faker = Faker::create();
        // foreach(range(1,20) as $index)
        // {
        //     DB::table('book_order')->insert([
        //         'user_id' => $faker->user_id,
        //         'book_id' => $faker->book_id,
        //         'status' => $faker->status,
        //         'created_at' => $faker->dateTimeBetween('-6 month','+1 month')
        //     ]);
        // }

    }
}
