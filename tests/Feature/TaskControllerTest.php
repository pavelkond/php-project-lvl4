<?php

namespace Tests\Feature;

use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    private Task $task;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->task = Task::factory()->create(['name' => 'test']);
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $this->get(route('tasks.index'))
            ->assertOk()
            ->assertSessionHasNoErrors();
    }

    public function testCreate()
    {
        $this->get(route('tasks.create'))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('tasks.create'))
            ->assertOk()
            ->assertSessionHasNoErrors();
    }

    public function testStore()
    {
        $data = [
            'name' => 'test2',
            'status_id' => $this->task->status->id
        ];
        $this->post(route('tasks.store'), $data)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->post(route('tasks.store'), $data)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', [
            'name' => 'test2',
            'status_id' => $this->task->status->id,
            'created_by_id' => $this->user->getKey()
        ]);
    }

    public function testShow()
    {
        $this->get(route('tasks.show', $this->task))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('tasks.show', $this->task))
            ->assertOk()
            ->assertSessionHasNoErrors()
            ->assertSee($this->task->getAttribute('name'));
    }

    public function testEdit()
    {
        $this->get(route('tasks.edit', $this->task))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('tasks.edit', $this->task))
            ->assertOk()
            ->assertSessionHasNoErrors();
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'test2',
            'status_id' => $this->task->status->id
        ];
        $this->patch(route('tasks.update', $this->task), $data)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->patch(route('tasks.update', $this->task), $data)
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('tasks', [
            'name' => 'test2',
            'status_id' => $this->task->status->id
        ]);

        $this->assertDatabaseMissing('tasks', [
            'name' => 'test'
        ]);
    }

    public function testDestroy()
    {
        $this->delete(route('tasks.destroy', $this->task))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete(route('tasks.destroy', $this->task))
            ->assertStatus(403);

        $this->actingAs($this->task->createdBy)
            ->delete(route('tasks.destroy', $this->task))
            ->assertRedirect(route('tasks.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('tasks', [
            'name' => 'test',
            'created_by_id' => $this->task->createdBy->getKey()
        ]);
    }
}
