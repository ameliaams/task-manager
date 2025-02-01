@extends('layouts')

@section('title', 'Create Task')

@section('content')
<div class="container mt-4">
    <h2 class="mb-4">Create New Task</h2>

    <form id="addTaskForm" action="{{ route('tasks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="taskTitle" class="form-label">Title</label>
            <input type="text" class="form-control" id="taskTitle" name="title" required>
        </div>

        <div class="mb-3">
            <label for="taskDescription" class="form-label">Description</label>
            <textarea class="form-control" id="taskDescription" name="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Task</button>
        <a href="{{ route('tasks.index') }}" class="btn btn-secondary">Back to Task List</a>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#addTaskForm').submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url: "{{ route('tasks.store') }}",
            method: 'POST',
            data: formData,
            success: function(response) {
                alert(response.message);
                $('#taskTable').append(`
                    <tr>
                        <td>${response.data.title}</td>
                        <td>${response.data.description}</td>
                        <td>
                            <button class="btn btn-warning" onclick="editTask(${response.data.id})">Edit</button>
                            <button class="btn btn-danger" onclick="deleteTask(${response.data.id})">Delete</button>
                        </td>
                    </tr>
                `);
            },
            error: function(xhr) {
                alert("Gagal menambahkan task!");
            }
        });
    });
});
</script>
@endsection
