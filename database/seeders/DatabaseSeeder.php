<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
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
        // \App\Models\TodoList::factory(20)->create();
        TodoList::factory(20)
            ->has(TodoTask::factory()->count(10))
            ->create();

    }
}
