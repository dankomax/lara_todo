@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <p>Tasks from "{{ $list->title }}" list</p>
                    <a href="{{ route('list.index') }}">Back to Lists</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @elseif (session('error'))
                        <div class="alert alert-danger" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h2>Create new task</h2>
                    <form action="{{ route('task.store', $list) }}" method="post" class="form mb-4">
                        @csrf
                        <div class="form-row align-items-center">
                            <div class="col-6">
                                <input type="text" class="form-control mb-2" name="title" placeholder="New list" value="{{ old('title') }}">
                                @error('title')
                                    <div class="alert alert-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary mb-2">Create</button>
                            </div>
                        </div>
                    </form>

                    <ul class="list-group">
                        @foreach ($tasks as $task)
                            <div class="d-flex justify-content-between mb-1">
                                <div class="list-group-item list-group-item-action rounded mr-1">
                                    @if ($task->is_done)
                                        <del>{{ $task->title }}</del>
                                    @else
                                        {{ $task->title }}
                                    @endif
                                </div>

                                <form action="{{ route('task.update', $task->id) }}" method="post" class="form mr-1">
                                    @csrf
                                    @method('patch')
                                    <input name="position" value="{{ $task->position + 1 }}" hidden>
                                    <button type="submit" class="btn btn-lg btn-dark" {{ $task->position == count($list->todoTasks) ? 'disabled' : '' }}>&uarr;</button>
                                </form>

                                <form action="{{ route('task.update', $task->id) }}" method="post" class="form mr-1">
                                    @csrf
                                    @method('patch')
                                    <input name="position" value="{{ $task->position - 1 }}" hidden>
                                    <button type="submit" class="btn btn-lg btn-dark" {{ $task->position == 1 ? 'disabled' : '' }}>&darr;</button>
                                </form>

                                <form action="{{ route('task.update', $task->id) }}" method="post" class="form mr-1">
                                    @csrf
                                    @method('patch')
                                    <input name="is_done" value="{{ $task->is_done ? 0 : 1 }}" hidden>
                                    <button type="submit" class="btn btn-lg btn-success">&#10003;</button>
                                </form>

                                <form action="{{ route('task.destroy', $task->id) }}" method="post" class="form">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg btn-danger">&times;</button>
                                </form>
                            </div>
                        @endforeach
                    </ul>

                    <div class="mt-4">
                        {{ $tasks->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
