<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            ['id' => 1, 'name' => 'Best Seller'],
            ['id' => 2, 'name' => 'Appetizers'],
            ['id' => 3, 'name' => 'Main Courses'],
        ];

        foreach ($categories as $category) {
            $cat = \App\Models\Category::create($category);
        }
    }
}
