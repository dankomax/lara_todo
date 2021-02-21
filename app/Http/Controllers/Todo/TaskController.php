<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TodoTask;
use App\Models\TodoList;



class TaskController extends Controller
{

    /**
     * Store a newly created task in db.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  TodoList $list
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, TodoList $list)
    {

        $request->validate([
            'title' => 'required|unique:todo_lists|min:3|max:255'
        ]);

        $newList = new TodoTask([
            'title' => $request->title,
            'is_done' => false,
            'todo_list_id' => $list->id
        ]);
        $newList->save();

        return redirect(route('list.show', $list->id));
    }


    /**
     * Update the specified task in db.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $task = TodoTask::with('todoList')->findOrFail($id);

        if (auth()->user()->id == $task->todoList->user_id) {
            $task->update([
                'is_done' => $request->is_done
            ]);
        }

        return back();
    }

    /**
     * Remove the specified task from db.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $task = TodoTask::with('todoList')->findOrFail($id);

        if (auth()->user()->id == $task->todoList->user_id) {
            $task->delete();
        }

        return back();
    }
}
