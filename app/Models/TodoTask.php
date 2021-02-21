<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\TodoList;

class TodoTask extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title',
        'is_done',
        'todo_list_id'
    ];

    /**
     * Get the TodoList that has the task.
     */
    public function todoList()
    {
        return $this->belongsTo(TodoList::class);
    }
}
