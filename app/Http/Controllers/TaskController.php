<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::paginate(10);
        return TaskResource::collection($tasks);
    }

    public function show(Task $task)
    {
        return TaskResource::make($task);
    }

    public function store(TaskRequest $taskRequest)
    {
        $data = $taskRequest->validated();
        $task = Task::create($data);
        return TaskResource::make($task);
    }

    public function update(TaskRequest $taskRequest, Task $task)
    {
        $data = $taskRequest->validated();
        $task->update($data);
        $task->refresh();
        return TaskResource::make($task);
    }

    public function destroy(Task $task)
    {
        // abort_if(logic), 403, 'Unauthorized');
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
