<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('users')->insert([
            'name'=>'Lukas Yes',
            'email'=>'LukasYes@hotmail.com',
            'password'=>Hash::make('12345')
        ]);
}

}
