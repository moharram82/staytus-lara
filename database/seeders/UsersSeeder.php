<?php

namespace Database\Seeders;

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            ['id' => 1, 'name' => 'Mohammed Moharram', 'email' => 'admin@example.com', 'password' => bcrypt('12345678'), 'email_verified_at' => now()], // admin
        ];

        foreach ($users as $user) {
            $u = \App\Models\User::create($user);
        }
    }
}
