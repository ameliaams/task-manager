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

        <div class="mb-3">
            <label for="taskStatus" class="form-label">Status</label>
            <select class="form-select" id="taskStatus" name="is_completed" required>
                <option value="0">Uncompleted</option>
                <option value="1">Completed</option>
            </select>
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
                window.location.href = "{{ route('tasks.index') }}";
            },
            error: function(xhr) {
                alert("Gagal menambahkan task!");
            }
        });
    });
});
</script>
@endsection
