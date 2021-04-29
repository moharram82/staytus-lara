<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CategoryItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elements = [
            ['category_id' => 3, 'item_id' => 1],
            ['category_id' => 3, 'item_id' => 2],
            ['category_id' => 3, 'item_id' => 3],
            ['category_id' => 3, 'item_id' => 4],
            ['category_id' => 3, 'item_id' => 5],
        ];

        foreach ($elements as $element) {
            $ele = \App\Models\CategoryItem::create($element);
        }
    }
}
