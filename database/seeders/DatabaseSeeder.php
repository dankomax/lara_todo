<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\TodoList;
use \App\Models\TodoTask;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory(3)                          // 3 users
            ->has(TodoList::factory(20)           // each user has 20 lists
                ->has(TodoTask::factory(30)))     // each list contains 30 tasks
            ->create();
    }
}
