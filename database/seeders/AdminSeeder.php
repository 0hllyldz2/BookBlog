<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("admins")->insert([
            "name" => 'Hilal Yıldız',
            "email" => '0hllyldz2@gmail.com',
            "password" => bcrypt(1058),
        ]);
    }
}
