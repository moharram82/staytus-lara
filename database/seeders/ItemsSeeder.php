<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ItemsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            [
                'id' => 1,
                'name' => 'French Toast',
                'description' => 'With bacon or maple sauce.',
                'price' => 9.99
            ],
            [
                'id' => 2,
                'name' => 'Lumberjack Omelet',
                'description' => 'With ham, sausage, spinach, mushrooms.',
                'price' => 10.99
            ],
            [
                'id' => 3,
                'name' => 'Green Curry Chicken',
                'description' => 'Green curry paste, bamboo, shoots, capsicum, and green beans served with Thai jasmine rice.',
                'price' => 165.00
            ],
            [
                'id' => 4,
                'name' => 'Golden Chicken Wok',
                'description' => 'Tossed bok choi, broccoli, cabbage, mushrooms, garlic with oyster sauce.',
                'price' => 150.50
            ],
            [
                'id' => 5,
                'name' => 'Honey Glazed Teriyaki Chicken',
                'description' => 'With ham, sausage, spinach, mushrooms.',
                'price' => 124.99
            ],
        ];

        foreach ($items as $item) {
            $it = \App\Models\Item::create($item);
        }
    }
}
