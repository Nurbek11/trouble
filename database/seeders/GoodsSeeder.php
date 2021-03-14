<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GoodsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0; $i < 50; $i++) {
            DB::table('goods')->insert([
                'category_id' => rand(1, 10),
                'name' => Str::random(10) . '_good',
                'price' => strval(rand(100, 10000)),
                'available'=>rand(1,0)
            ]);
        }
    }
}
