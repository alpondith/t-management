<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use App\Http\Resources\TaskResource;
use App\Jobs\SendEmailOnTaskCreate;
use App\Models\Task;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = Task::where('user_id', auth()->id())->paginate(10);
        return TaskResource::collection($tasks);
    }

    public function show(Task $task)
    {
        abort_if($task->user_id != auth()->id(), 403, 'You are unauthorized to view this task');
        return TaskResource::make($task);
    }

    public function store(TaskRequest $taskRequest)
    {
        $data = $taskRequest->validated();
        $task = Task::create($data);
        SendEmailOnTaskCreate::dispatch(auth()->user()->email, "Task has been created successfully");
        return TaskResource::make($task);
    }

    public function update(TaskRequest $taskRequest, Task $task)
    {
        abort_if($task->user_id != auth()->id(), 403, 'You are unauthorized to update this task');
        $data = $taskRequest->validated();
        $task->update($data);
        $task->refresh();
        return TaskResource::make($task);
    }

    public function destroy(Task $task)
    {
        abort_if($task->user_id != auth()->id(), 403, 'You are unauthorized to delete this task');
        $task->delete();
        return response()->json(['message' => 'Task deleted successfully']);
    }
}
