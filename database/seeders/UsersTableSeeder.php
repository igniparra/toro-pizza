<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the user database seeds.
     */
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => null,
                'password' => '$2y$12$QqBmXROtl4jq.V5LnDeEmuRm5JkEY9lXValefi2FlNntNS5DD4VBy',
                'remember_token' => null,
                'role' => 'admin'
            ],
            [
                'name' => 'customer',
                'email' => 'customer@customer.com',
                'email_verified_at' => null,
                'password' => '$2y$12$u973Wcl1uv7LCH28E7MQcuhLRd00FOhKkpuEVbg4FZu.a2J0Be20K',
                'remember_token' => null,
                'role' => 'customer'
            ]
        ]);
    }

}
