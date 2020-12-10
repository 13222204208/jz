<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        DB::table('users')->insert([
            'username'=>'myadmin',
            'name' => '夜店小王子',
            'role' =>  '超级管理员',
            'password' => bcrypt('12345678'),
            'created_at' => '2020-11-18 16:19:51',
            'updated_at' => '2020-11-18 18:19:51'
        ]);   

        DB::table('userinfo')->insert([
            'username'=>'yangpanda',
            'password' => bcrypt('123456'),
            'wx_id' => '13222204209',
            'phone' => '13222204209'
        ]);    
    }
}
