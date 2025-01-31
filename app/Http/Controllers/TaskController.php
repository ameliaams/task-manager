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
            'status' => 'success',
            'message' => 'Berhasil Menampilkan Seluruh Data!',
            'data' => $this->taskService->getAllTasks()
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        try {
            $task = $this->taskService->createTask($validatedData);
            return response()->json([
                'status' => 'success',
                'message' => 'Task Berhasil Ditambahkan!',
                'data' => $task
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task Gagal Dibuat!',
                'data' => $err->getMessage()
            ], 500);
        }
    }

    public function show($id): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Menampilkan Data!',
            'data' => $this->taskService->getTaskById($id)
        ]);
    }

    public function update(Request $request, $id): JsonResponse
    {
        $validatedData = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|nullable|string',
            'is_completed' => 'sometimes|boolean'
        ]);

        try {
            $task = $this->taskService->updateTask($validatedData, $id);
            return response()->json([
                'status' => 'success',
                'message' => 'Task Berhasil Diperbarui!',
                'data' => $task
            ], 201);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task Gagal Diperbarui!',
                'data' => $err->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->taskService->deleteTask($id);
            return response()->json([
                'status' => 'success',
                'success' => 'Task Berhasil Dihapus'
            ]);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task Gagal Dihapus!',
                'data' => $err->getMessage()
            ], 500);
        }
    }
}
