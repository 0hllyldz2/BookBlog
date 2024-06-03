<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $faker = Faker::create();
        for ($i = 0; $i < 4; $i++) {
            $title = $faker->sentence(6);
            $width = $faker->numberBetween(500, 850);
            $height = $faker->numberBetween(100, 300);
            $contentArray = $faker->paragraphs(6);
            $content = implode("\n\n", $contentArray);
            DB::table("articles")->insert([
                "category_id" => rand(1, 12),
                "title" => $title,
                "image" => $faker->imageUrl($width, $height, 'cats', true, 'Book Blog'),
                "content" => $content,
                "slug" => Str::slug($title),
                "created_at" => $faker->dateTime('now'),
                "updated_at" => now()
            ]);
        }
    }
}
