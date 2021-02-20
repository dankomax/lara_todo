@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    Tasks
                    <a href="{{ route('list.index') }}">Back to Lists</a>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
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

                    <p>{{ $list->title }}</p>
                    @foreach ($list->todoTasks as $task)
                        <p>{{ $task->title }}</p>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
