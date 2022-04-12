<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskStatus extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tasks()
    {
        $this->hasMany(Task::class, 'status_id');
    }

    public function getRelatedTasksCount(): int
    {
        return self::query()
            ->join('tasks', 'tasks.status_id', '=', 'task_status.id')
            ->count();
    }
}
