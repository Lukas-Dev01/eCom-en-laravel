<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Db::table('products')->insert([
    [
        'name'=>'CyberPowerPC AMETHYST II',
        "price"=>"1100",
        "description"=>"CyberPowerPC AMETHYST II 241V Mid-Tower Gaming Case w/ Side Tempered Glass Swing Door + 3x ARGB Fans (Black)",
        "category"=>"Computers",
        "gallery"=>"https://www.cyberpowerpc.com/images/cs/amethystii241v/cs-450-167_400.png"
    ],
    [
        'name'=>'CyberPowerPC ONYXIA III',
        "price"=>"1450",
        "description"=>"CyberPowerPC ONYXIA III 243 Mid-Tower Gaming Case w/ Front & Side Tempered Glass NO FAN (White Color)",
        "category"=>"Computers",
        "gallery"=>"https://www.cyberpowerpc.com/images/cs/onyxia3/CS-450-162_400.png"
    ],
    [
        'name'=>'CyberPowerPC FURION',
        "price"=>"2215",
        "description"=>"CyberPowerPC FURION Mid-Tower Gaming Case w/ front/Top & Both Side Tempered Glass + 6X Dual Light Loop 120mm RGB Fans & Controller",
        "category"=>"Computers",
        "gallery"=>"https://www.cyberpowerpc.com/images/cs/cpfurion/cs-450-134_400.png?v2"
    ],   
    [
        'name'=>'NZXT H510',
        "price"=>"4059",
        "description"=>"NZXT H510 Mid-Tower Gaming Case w/ Tempered Glass Window panel (Matte White)",
        "category"=>"Computers",
        "gallery"=>"https://www.cyberpowerpc.com/images/cs/H510/CS-211-222_400.png"
    ],
    [
        'name'=>'CyberpowerPC Eclipse',
        "price"=>"2039",
        "description"=>"CyberpowerPC Eclipse P418R DRGB ATX Mid-Tower High Air Flow Gaming Case + 3x 120mm ARGB Fans (Black Color)",
        "category"=>"Computers",
        "gallery"=>"https://www.cyberpowerpc.com/images/cs/p418R/cs-450-158_400.png"
    ]
        ]);
    }
}