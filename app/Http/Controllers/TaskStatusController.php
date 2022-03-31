<?php

namespace App\Http\Controllers;

use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $taskStatuses = TaskStatus::all();

        return response()
            ->view('task_status.index', compact('taskStatuses'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', TaskStatus::class);

        return response()
            ->view('task_status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->authorize('create', TaskStatus::class);

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses'
        ]);
        $status = new TaskStatus();
        $status->fill($data);
        $status->save();

        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\Response
     */
    public function edit(TaskStatus $taskStatus)
    {
        $this->authorize('update', $taskStatus);

        return response()
            ->view('task_status.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, TaskStatus $taskStatus)
    {
        $this->authorize('update', $taskStatus);

        $data = $this->validate($request, [
            'name' => 'required|unique:task_statuses'
        ]);
        $taskStatus->fill($data);
        $taskStatus->save();

        return redirect()
            ->route('task_statuses.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(TaskStatus $taskStatus)
    {
        $this->authorize('delete', $taskStatus);

        $taskStatus->delete();

        return redirect()
            ->route('task_statuses.index');
    }
}
