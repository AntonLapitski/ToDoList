@extends('layouts.app')

@section('content')
    <div class="col-md-offset-2 col-md-8">
        <div class="row">
            <h1>ToDo List</h1>
        </div>

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
            <form action="{{ route('tasks.update', [$task->id]) }}" method="POST">
                {{ csrf_field() }}
                <input type="hidden" name="_method" value="PUT">
                <div class="form-group">
                    <input type="text" name="updatedName" class="form-control input-group-lg" value="{{ $task->name }}">
                </div>
                <div class="form-group">
                    <input type="submit" value="Save Changes" class="btn btn-success btn-lg">
                    <a href="{{route('tasks.index')}}" class="btn btn-danger btn-lg">Go back!</a>
                </div>
            </form>
        </div>

    </div>

@endsection
