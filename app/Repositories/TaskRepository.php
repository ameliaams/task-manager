<?php

namespace App\Repositories;

use App\Interfaces\TaskInterface;
use App\Models\Task;

class TaskRepository implements TaskInterface
{
    public function __construct(protected Task $task) {}

    public function getAll()
    {
        return Task::all();
    }

    public function getById($id)
    {
        return $this->task->findOrFail($id);
    }

    public function create($data)
    {
        return Task::create($data);
    }
}
