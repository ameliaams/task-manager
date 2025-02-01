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
        <tbody id="taskTable">
            @foreach ($tasks as $task)
            <tr id="task-{{ $task->id }}">
                <td>{{ $task->title }}</td>
                <td>{{ $task->description }}</td>
                <td>
                    @if ($task->is_completed)
                        <span class="badge bg-success">Completed</span>
                    @else
                        <span class="badge bg-danger">Uncompleted</span>
                    @endif
                </td>
                <td>
                    <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit</a>
                    <button class="btn btn-danger delete-task" data-id="{{ $task->id }}">Delete</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $(document).on('click', '.delete-task', function() {
            var taskId = $(this).data('id');

            if (confirm('Are you sure you want to delete this task?')) {
                $.ajax({
                    url: 'api/tasks/' + taskId,
                    type: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            alert(response.message);
                            loadTasks();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error: ' + error);
                        alert('An error occurred while deleting the task.');
                    }
                });
            }
        });

        // load data terbaru
        function loadTasks() {
            $.ajax({
                url: '{{ route('tasks.index') }}',
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    var tbody = $('table tbody');
                    tbody.empty();

                    response.data.forEach(function(task) {
                        var statusBadge = task.is_completed
                            ? '<span class="badge bg-success">Completed</span>'
                            : '<span class="badge bg-danger">Uncompleted</span>';

                        tbody.append(`
                            <tr id="task-${task.id}">
                                <td>${task.title}</td>
                                <td>${task.description}</td>
                                <td>${statusBadge}</td>
                                <td>
                                    <a href="/tasks/${task.id}/edit" class="btn btn-warning">Edit</a>
                                    <button class="btn btn-danger delete-task" data-id="${task.id}">Delete</button>
                                </td>
                            </tr>
                        `);
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error loading tasks: ' + error);
                }
            });
        }
    });
</script>

@endsection
