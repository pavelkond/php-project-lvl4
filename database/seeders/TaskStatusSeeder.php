<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    private const DEFAULT_STATUSES = [
        "Новый",
        "В работе",
        "На тестировании",
        "Завершен"
    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::DEFAULT_STATUSES as $taskStatus) {
            TaskStatus::factory()->create(['name' => $taskStatus]);
        }
    }
}
