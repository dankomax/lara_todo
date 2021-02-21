<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TodoList;
use App\Models\TodoTask;

class ListController extends Controller
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
     * Display a listing of TodoLists.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $todoLists = auth()->user()->todoLists()->orderBy('created_at', 'desc')->paginate(5);

        // redirect to last available page of lists, if there is no lists on requested page
        if($request->page > $todoLists->lastPage()) {
            return redirect(route('list.index', ['page' => $todoLists->lastPage()]));
        }

        return view('lists.index', ['todoLists' => $todoLists]);
    }

    /**
     * Store a newly created TodoList.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:todo_lists|min:3|max:255',
        ]);

        $newList = new TodoList([
            'title' => $request->title,
            'user_id' => auth()->user()->id
        ]);
        $newList->save();

        return redirect(route('list.index'));
    }

    /**
     * Display the specified TodoList.
     *
     * @param  TodoList $list
     * @return \Illuminate\Http\Response
     */
    public function show(TodoList $list, Request $request)
    {
        if (auth()->user()->id == $list->user_id) {
            $tasks = TodoTask::where('todo_list_id', $list->id)->orderBy('created_at', 'desc')->paginate(5);

            // redirect to last available page of list, if there is no tasks on requested page
            if($request->page > $tasks->lastPage()) {
                return redirect(route('list.show', [$list->id, 'page' => $tasks->lastPage()]));
            }

            return view('lists.show', ['list' => $list, 'tasks' => $tasks]);
        }

        // show error if user is trying to to access list that belongs to another user
        return redirect(route('list.index'))->with('error', 'Unauthorized!');
    }

    /**
     * Remove the specified TodoList from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $list = TodoList::findOrFail($id);

        if (auth()->user()->id == $list->user_id) {
            $list->delete();
        }

        return back();
    }
}
