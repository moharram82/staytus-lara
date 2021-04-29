<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $menus = [
            ['id' => 1, 'name' => 'Breakfast Menu'],
            ['id' => 2, 'name' => 'Lunch Menu'],
            ['id' => 3, 'name' => 'Dinner Menu'],
        ];

        foreach ($menus as $menu) {
            $men = \App\Models\Menu::create($menu);
        }
    }
}
