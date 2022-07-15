<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('colors')->insert([
            [
                'id'            => 1,
                'name'            => 'Purple',
                'color_hex'            => '#b27ef8',
            ],
            [
                'id'            => 2,
                'name'            => 'Red',
                'color_hex'            => '#f56060',
            ],
            [
                'id'            => 3,
                'name'            => 'White',
                'color_hex'            => '#fff',
            ],
            [
                'id'            => 4,
                'name'            => 'Green',
                'color_hex'            => '#44c28d',
            ]
        ]);
    }
}
