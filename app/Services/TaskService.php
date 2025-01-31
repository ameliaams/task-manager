<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Interfaces\TaskInterface;

class TaskService
{
    public function __construct(protected TaskInterface $taskRepository) {}

    public function getAllTasks()
    {
        return $this->taskRepository->getAll();
    }

    public function getTaskById($id)
    {
        return $this->taskRepository->getById($id);
    }

    public function createTask($data)
    {
        return $this->taskRepository->create($data);
    }

    public function updateTask($data, $id)
    {
        return $this->taskRepository->update($data, $id);
    }
}
