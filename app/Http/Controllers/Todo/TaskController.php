<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\TodoTask;
use App\Models\TodoList;

class TaskController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // all actions available to authenticated users only
        $this->middleware('auth');
    }

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

        $position = count($list->todoTasks) + 1;

        $newList = new TodoTask([
            'title' => $request->title,
            'is_done' => false,
            'todo_list_id' => $list->id,
            'position' => $position
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

        $list = $task->todoList;

        // check if user trying to update task that belongs to him/her
        if (auth()->user()->id == $list->user_id) {
            // check if user wants to update "is_done" status
            if (isset($request->is_done)) {
                $task->update([
                    'is_done' => $request->is_done
                ]);
            // check if user wants to update task "position"
            } else if ($request->position) {
                // make sure that user changing "position" in available ranges
                if ($request->position > 0 && $request->position <= count($list->todoTasks)) {
                    $taskDown = TodoTask::with('todoList')
                        ->where('todo_list_id', $list->id)
                        ->where('position', $request->position)
                        ->first();
                    $taskDown->update([
                        'position' => $task->position
                    ]);
                    $task->update([
                        'position' => $request->position
                    ]);
                } else {
                    // show error if user is trying to move task out of available "position" ranges
                    return redirect(route('list.show', $list->id))->with('error', 'Impossible action!');
                }
            }
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

            // get all tasks positioned higher then task user wants to delete
            $tasksDown = TodoTask::with('todoList')
                ->where('todo_list_id', $task->todoList->id)
                ->where('position', '>', $task->position)
                ->get();

            // decrease tasks position on one level down
            foreach ($tasksDown as $t) {
                $t->update([
                    'position' => $t->position - 1
                ]);
            }

            $task->delete();
        }

        return back();
    }
}
