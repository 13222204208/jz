<?php

namespace Database\Seeders;

use App\Models\BuildOrder;
use App\Models\User;
use App\Models\Userinfo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        //User::factory()->count(1)->create();  
        //Userinfo::factory()->count(21)->create();
        //BuildOrder::factory()->count(10)->create();
        $user = new User;
        $user->username = 'myadmin';
        $user->password = Hash::make('123456');
        $user->save();
    }
}
