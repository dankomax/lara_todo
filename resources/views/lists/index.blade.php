@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8">
            <div class="card">
                <div class="card-header">
                    <h4>Todo Lists</h4>
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

                    <h2>Create new list of tasks</h2>
                    <form action="{{ route('list.store') }}" method="post" class="form mb-4">
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
                        @foreach ($todoLists as $list)
                            <li class="d-flex justify-content-between mb-1">
                                <a href="{{ route('list.show', $list->id) }}" class="list-group-item list-group-item-action rounded mr-1">{{ $list->title }}</a>
                                <form action="{{ route('list.destroy', $list->id) }}" method="post" class="form">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-lg btn-danger">&times;</button>
                                </form>
                            </li>
                        @endforeach
                    </ul>

                    <div class="mt-4">
                        {{ $todoLists->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
