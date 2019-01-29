@extends('layouts.app')


@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="row">
            <h1>ToDo List</h1>
        </div>

        @if(session('success_created'))
            <div class="alert alert-success">
                <strong>{{session('success_created')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('success_deleted'))
            <div class="alert alert-success">
                <strong>{{session('success_deleted')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(session('success_updated'))
            <div class="alert alert-success">
                <strong>{{session('success_updated')}}</strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        @endif

        @if(count($errors)>0)
            <div class="alert alert-danger">
                <strong>Error:</strong>
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <form action="{{ route('tasks.store') }}" method="POST">
                {{ csrf_field() }}
                <div class="col-md-9">
                    <input type="text" name="newTaskName" class="form-control">
                </div>
                <div class="col-md-3">
                    <input type="submit" class="btn btn-primary btn-block" value="Add Task">
                </div>
            </form>
        </div>

        @if(count($storedTasks) > 0)
            <table class="table">
                <thead>
                    <th>Task #</th>
                    <th>Name</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </thead>
                <tbody>
                @foreach($storedTasks as $task)
                    <tr>
                        <th>{{ $task->id }}</th>
                        <td>{{ $task->name }}</td>
                        <td><a href="{{ route('tasks.edit', ['tasks' => $task->id]) }}" class="btn btn-default">Edit</a></td>
                        <td>
                            <form action="{{ route('tasks.destroy', ['tasks'=>$task->id]) }}" method="POST">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="Delete">
                                <input type="submit" class="btn btn-danger" value="Delete">
                            </form>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <div class="row text-center">
            {{ $storedTasks->links() }}
        </div>
    </div>
@endsection
