<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use \App\Models\User;
use \App\Models\TodoList;
use \App\Models\TodoTask;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $numTasks = 20;     // generate number of tasks per list

        $positions = range(1, $numTasks);
        $positionsArr = array_map ( function($pos) {
            return ["position" => $pos];
        }, $positions );
        $sequence = new Sequence(...$positionsArr);

        User::factory(3)                                 // 3 users
            ->has(TodoList::factory(15)                  // each user has 15 list
                ->has(TodoTask::factory($numTasks)       // each list contains 20 tasks
                    ->state($sequence)
                )
            )
            ->create();

    }
}
