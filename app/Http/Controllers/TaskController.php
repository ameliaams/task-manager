<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(): JsonResponse
    {
        return response()->json([
            'data' => $this->taskService->getAllTasks()
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'is_completed' => 'required|boolean',
        ]);

        try {
            $task = $this->taskService->createTask($validatedData);
            return response()->json([
                'success' => 'Task Berhasil Ditambahkan!',
                'data' => $task
            ], 201);
        } catch (\Throwable $err) {
            return response()->json(['error' => 'Task Gagal Dibuat!', 'message' => $err->getMessage()], 500);
        }
    }

    public function show($id): JsonResponse
    {
        return response()->json([
            'data' => $this->taskService->getTaskById($id)
        ]);
    }
}
