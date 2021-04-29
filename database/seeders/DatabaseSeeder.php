<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersSeeder::class);
        $this->call(MenusSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(ItemsSeeder::class);
        $this->call(ItemMenuSeeder::class);
        $this->call(CategoryItemSeeder::class);
    }
}
