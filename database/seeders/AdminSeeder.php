<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            [
                'name'            => 'Admin 1',
                'email'            => 'admin1@gmail.com',
                'phone'            => '0922353113',
                'password'            => Hash::make('rootadmin'),
            ],
            [
                'name'            => 'Admin 2',
                'email'            => 'admin2@gmail.com',
                'phone'            => '0922353112',
                'password'         => Hash::make('rootadmin'),
            ]
        ]);
    }
}
