<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasks = Task::all();
        return response()
            ->view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Task::class);

        $statusSelect = TaskStatus::query()
            ->select('id', 'name')
            ->get()
            ->mapWithKeys(fn($item, $key) => [$item['id'] => $item['name']])
            ->all();
        $assignerSelect = User::query()
            ->select('id', 'name')
            ->get()
            ->mapWithKeys(fn($item, $key) => [$item['id'] => $item['name']])
            ->all();
        $labelSelect = Label::query()
            ->select('id', 'name')
            ->get()
            ->mapWithKeys(fn($item, $key) => [$item['id'] => $item['name']])
            ->all();
        return response()
            ->view('task.create', compact('statusSelect', 'assignerSelect', 'labelSelect'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', Task::class);

        $data = $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array'
        ]);
        $task = new Task();
        $task->fill($data);
        $task->createdBy()->associate(Auth::user());
        $task->save();
        $labelsIds = $data['labels'] ?? [];
        $task->labels()->sync($labelsIds);

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        $this->authorize('view', $task);

        return response()
            ->view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $this->authorize('update', $task);

        $statusSelect = TaskStatus::query()
            ->select('id', 'name')
            ->get()
            ->mapWithKeys(fn($item, $key) => [$item['id'] => $item['name']])
            ->all();
        $assignerSelect = User::query()
            ->select('id', 'name')
            ->get()
            ->mapWithKeys(fn($item, $key) => [$item['id'] => $item['name']])
            ->all();
        $labelSelect = Label::query()
            ->select('id', 'name')
            ->get()
            ->mapWithKeys(fn($item, $key) => [$item['id'] => $item['name']])
            ->all();
        return response()
            ->view('task.edit', compact('task', 'statusSelect', 'assignerSelect', 'labelSelect'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $data = $this->validate($request, [
            'name' => 'required',
            'description' => 'nullable',
            'status_id' => 'required|exists:task_statuses,id',
            'assigned_to_id' => 'nullable|exists:users,id',
            'labels' => 'nullable|array'
        ]);
        $task->fill($data);
        $task->save();
        $labelsIds = $data['labels'] ?? [];
        $task->labels()->sync($labelsIds);

        return redirect()
            ->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Task $task
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        $task->delete();

        return redirect()
            ->route('tasks.index');
    }
}
