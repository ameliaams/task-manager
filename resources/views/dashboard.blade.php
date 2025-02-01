@extends('layouts')

@section('title', 'Dashboard')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Task List</h2>

    <a href="{{ route('tasks.create') }}" class="btn btn-primary float-end mb-3">Add Task</a>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tasks as $task)
            <tr>
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    @if ($task->is_completed)
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-danger">Uncompleted</span>
                    @endif
                </td>
                <td><button type="button" class="btn btn-warning" href="{{ url('/api/tasks/{id}') }}">Edit</button>
                    <button type="button" class="btn btn-danger">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
