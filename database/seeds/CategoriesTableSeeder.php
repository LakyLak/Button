<?php

use App\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder {
        
    public function run()
    {
        $faker = Faker\Factory::create();

        // Category::truncate(); 

        foreach (range(1, 100) as $index) {
            Category::create([
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph(1),
                'status' => $faker->numberBetween(0,1),
                'image' => $faker->imageUrl(300, 200)
            ]);
        }
    }

    // For more examples look
    // https://github.com/fzaninotto/Faker#formatters
}