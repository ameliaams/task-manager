<?php

namespace App\Http\Controllers;

use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TaskController extends Controller
{
    public function __construct(protected TaskService $taskService) {}

    public function index(Request $request)
    {
        $tasks = $this->taskService->getAllTasks();
        if ($request->expectsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil Menampilkan Seluruh Data!',
                'data' => $tasks
            ]);
        }

        return view('dashboard', compact('tasks'));
    }

    public function create()
    {
        return view('task.create');
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'is_completed' => 'boolean'
            ]);

            $task = $this->taskService->createTask($validatedData);

            if (!$task) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Gagal menambahkan task!'
                ], 500);
            }

            if ($request->expectsJson()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Task Berhasil Ditambahkan!',
                    'data' => $task
                ], 201);
            }
            return redirect()->route('tasks.index')->with('success', 'Task created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validasi Gagal!',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $err) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task Gagal Dibuat!',
                'error' => $err->getMessage()
            ], 500);
        }
    }


    public function show($id): JsonResponse
    {
        $task = $this->taskService->getTaskById($id);

        if (!$task) {
            return response()->json([
                'status' => 'error',
                'message' => 'Task tidak ditemukan!'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil Menampilkan Data!',
            'data' => $task
        ], 200);
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
            $deleted = $this->taskService->deleteTask($id);
            if (!$deleted) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Task tidak ditemukan!'
                ], 404);
            }

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
