<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $elements = [
            ['item_id' => 1, 'menu_id' => 1],
            ['item_id' => 2, 'menu_id' => 1],
            ['item_id' => 3, 'menu_id' => 2],
            ['item_id' => 4, 'menu_id' => 2],
            ['item_id' => 5, 'menu_id' => 3],
        ];

        foreach ($elements as $element) {
            $ele = \App\Models\ItemMenu::create($element);
        }
    }
}
