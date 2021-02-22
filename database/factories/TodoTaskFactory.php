<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\TodoList;
use App\Models\TodoTask;



class TodoTaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = TodoTask::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(4),
            'is_done' => 0,
            'position' => $this->faker->numberBetween(0, 20),
            'todo_list_id'=> TodoList::factory()
        ];
    }
}
