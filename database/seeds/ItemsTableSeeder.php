<?php

use App\Item;
use Illuminate\Database\Seeder;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        // DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        // Item::truncate();
        // DB::table('items')->delete();

        foreach (range(1, 100) as $index) {
            Item::create([
                'category_id' => $this->getRandomItemId('App\Category'),
                'name' => $faker->sentence(3),
                'description' => $faker->paragraph(1),
                'price' => $faker->randomFloat(2, 0, 1000),
                'status' => $faker->numberBetween(0, 1),
            ]);
        }
    }

    private function getRandomItemId($table)
    {
        $item = $table::inRandomOrder()->first();
        return $item->id;
    }
}
