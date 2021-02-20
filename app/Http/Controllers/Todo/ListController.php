<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TodoList;

class ListController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of TodoLists.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $todoLists = auth()->user()->todoLists()->orderBy('created_at', 'desc')->get();
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
        $validated = $request->validate([
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $list = TodoList::with('todoTasks')->findOrFail($id);
        if (auth()->user()->id == $list->user_id) {
            // dd($list);
            return view('lists.show', ['list' => $list]);
        }
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

        return redirect(route('list.index'));
    }
}
