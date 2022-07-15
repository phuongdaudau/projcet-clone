<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('sizes')->insert([
            [
                'id'            => 1,
                'name'            => 'XS',
            ],
            [
                'id'            => 2,
                'name'            => 'S',
            ],
            [
                'id'            => 3,
                'name'            => 'M',
            ],
            [
                'id'            => 4,
                'name'            => 'L',
            ],
            [
                'id'            => 5,
                'name'            => 'XL',
            ],
            [
                'id'            => 6,
                'name'            => 'XXL',
            ]
        ]);
    }
}
