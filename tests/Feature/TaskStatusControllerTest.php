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
        $this->taskStatus = TaskStatus::factory()->make([
            'name' => 'test'
        ]);
        $this->taskStatus->save();
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
        $response->assertSee('Статусы');
    }

    public function testCreateWithoutAuth()
    {
        $this->get(route('task_statuses.create'))
            ->assertStatus(403);
    }

    public function testCreateWithAuth()
    {
        $this->actingAs($this->user)
            ->get(route('task_statuses.create'))
            ->assertSessionHasNoErrors()
            ->assertOk()
            ->assertSeeInOrder(['Создать статус', 'form' ,'Создать']);
    }

    public function testStoreWithoutAuth()
    {
        $data = ['name' => 'status1'];
        $this->post(route('task_statuses.store'), $data)
            ->assertStatus(403);

        $this->assertDatabaseMissing('task_statuses', $data);
    }

    public function testStoreWithAuth()
    {
        $data = ['name' => 'status1'];
        $this->actingAs($this->user)
            ->post(route('task_statuses.store'), $data)
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
    }

    public function testEditWithoutAuth()
    {
        $this->get(route('task_statuses.edit', $this->taskStatus))
            ->assertStatus(403);
    }

    public function testEditWithAuth()
    {
        $this->actingAs($this->user)
            ->get(route('task_statuses.edit', $this->taskStatus))
            ->assertOk()
            ->assertSessionHasNoErrors()
            ->assertSeeInOrder([
                'Изменение статуса',
                'form',
                $this->taskStatus->getAttribute('name'),
                'Обновить'
            ]);
    }

    public function testUpdateWithAuth()
    {
        $data = ['name' => 'status1'];
        $this->patch(route('task_statuses.update', $this->taskStatus), $data)
            ->assertStatus(403);

        $this->assertDatabaseMissing('task_statuses', $data);
    }

    public function testUpdateWithoutAuth()
    {
        $data = ['name' => 'status1'];
        $this->actingAs($this->user)
            ->patch(route('task_statuses.update', $this->taskStatus), $data)
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('task_statuses', $data);
        $this->assertDatabaseMissing('task_statuses', [
            'name' => 'test'
        ]);
    }

    public function testDestroyWithoutAuth()
    {
        $this->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertStatus(403);

        $this->assertDatabaseHas('task_statuses', [
            'name' => 'test'
        ]);
    }

    public function testDestroyWithAuth()
    {
        $this->actingAs($this->user)
            ->delete(route('task_statuses.destroy', $this->taskStatus))
            ->assertRedirect(route('task_statuses.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('task_statuses', [
            'name' => 'test'
        ]);
    }
}
