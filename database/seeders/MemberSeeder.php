<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('members')->insert([
            [
                'id'                => 1,
                'name'              => 'Member 1',
                'email'             => 'member1@gmail.com',
                'phone'             => '0922353110',
                'password'          => bcrypt('rootmember'),
            ],
            [
                'id'                => 2,
                'name'              => 'Member 2',
                'email'             => 'member2@gmail.com',
                'phone'             => '0922353111',
                'password'          => bcrypt('rootmember'),
            ]
        ]);
    }
}
