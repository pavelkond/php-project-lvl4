<?php

namespace Tests\Feature;

use App\Models\Label;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LabelControllerTest extends TestCase
{
    use RefreshDatabase;

    private Label $label;
    private User $user;

    protected function setUp(): void
    {
        parent::setUp();
        $this->label = Label::factory()->create(['name' => 'test']);
        $this->user = User::factory()->create();
    }

    public function testIndex()
    {
        $this->get(route('labels.index'))
            ->assertOk()
            ->assertSessionHasNoErrors();
    }

    public function testCreate()
    {
        $this->get(route('labels.create'))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('labels.create'))
            ->assertOk()
            ->assertSessionHasNoErrors();
    }

    public function testStore()
    {
        $data = [
            'name' => 'test2'
        ];
        $this->post(route('labels.store'), $data)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->post(route('labels.store'), $data)
            ->assertRedirect(route('labels.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('labels', [
            'name' => 'test2'
        ]);
    }

    public function testEdit()
    {
        $this->get(route('labels.edit', $this->label))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->get(route('labels.edit', $this->label))
            ->assertOk()
            ->assertSessionHasNoErrors();
    }

    public function testUpdate()
    {
        $data = [
            'name' => 'test2'
        ];
        $this->patch(route('labels.update', $this->label), $data)
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->patch(route('labels.update', $this->label), $data)
            ->assertRedirect(route('labels.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('labels', [
            'name' => 'test'
        ]);

        $this->assertDatabaseHas('labels', [
            'name' => 'test2'
        ]);
    }

    public function testDestroy()
    {
        $this->delete(route('labels.destroy', $this->label))
            ->assertStatus(403);

        $this->actingAs($this->user)
            ->delete(route('labels.destroy', $this->label))
            ->assertRedirect(route('labels.index'))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseMissing('labels', [
            'name' => 'test'
        ]);
    }
}
