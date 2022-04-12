<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskStatusRequest;
use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')
            ->except('index');
    }

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
        return response()
            ->view('task_status.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\TaskStatusRequest  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TaskStatusRequest $request)
    {
        $status = new TaskStatus();
        $status->fill($request->validated());
        $status->save();

        flash('Статус успешно создан')->success();
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
        return response()
            ->view('task_status.edit', compact('taskStatus'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\TaskStatusRequest  $request
     * @param  \App\Models\TaskStatus  $taskStatus
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TaskStatusRequest $request, TaskStatus $taskStatus)
    {
        $taskStatus->fill($request->validated());
        $taskStatus->save();

        flash('Статус успешно изменен')->success();
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
        $taskWithStatusCount = Task::query()
            ->where('status_id', $taskStatus->getKey())
            ->count();
        if ($taskWithStatusCount === 0) {
            $taskStatus->delete();
            flash('Статус успешно удален')->success();
            return redirect()
                ->route('task_statuses.index');
        }

        flash('Не удалось удалить статус')->error();
        return back();
    }
}
