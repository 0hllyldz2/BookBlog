<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages=['Hakkımızda', 'Kariyer', 'Vizyonumuz', 'Misyonumuz'];
        $count=0;
        foreach ($pages as $page) {
            $count++;
             DB::table("pages")->insert([
                 "title"=> $page,
                 "slug"=> Str::slug($page),
                 "image"=> 'https://cf.kizlarsoruyor.com/q10966204/6c8c7810-37dc-4f32-aa83-7000b833b787.jpg',
                 "content"=> 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.
                              Optio, facere commodi aliquid incidunt dolor cumque accusantium
                              consequatur obcaecati ratione cum veniam excepturi officiis
                              sapiente quae libero eaque illum praesentium aperiam.',
                "order"=>$count,
                 "created_at"=>now(),
                 "updated_at"=>now()
             ]);
         }
    }
}
