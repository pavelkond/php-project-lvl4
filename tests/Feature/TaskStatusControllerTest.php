<?php

namespace Tests\Feature;

use App\Models\TaskStatus;
use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    private TaskStatus $taskStatus;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->taskStatus = new TaskStatus();
        $this->taskStatus->fill(['name' => 'test']);
        $this->taskStatus->save();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
    }

    public function testCreateWithoutLogin()
    {
        $this->get(route('task_statuses.create'))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('task_statuses.create'))
            ->assertSessionHasNoErrors()
            ->assertOk();
    }

    public function testStore()
    {
        $data = ['name' => 'status1'];
        $this->post(route('task_statuses.store'))
            ->assertStatus(403);

        $this->assertDatabaseMissing('task_statuses', $data);

        $this->actingAs($this->user)
            ->post(route('task_statuses.store'), $data)
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEdit()
    {
        $this->get(route('task_statuses.edit', $this->taskStatus))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('task_statuses.edit', $this->taskStatus))
            ->assertOk()
            ->assertSessionHasNoErrors();
    }

    public function testUpdate()
    {
        $data = ['name' => 'status1'];

        $this->patch(route('task_statuses.update', $this->taskStatus))
            ->assertStatus(403);

        $this->assertDatabaseMissing('task_statuses', $data);

        $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $this->taskStatus), $data)
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testDestroy()
    {
        $this->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('task_statuses', [
            'name' => 'test'
        ]);
    }

}
