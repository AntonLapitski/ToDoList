<?php

namespace Tests\Feature\app\Http\Controllers;

use App\Task;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Class TaskControllerTest
 * @package Tests\Feature\app\Http\Controllers
 */
class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var
     */
    private $tasks;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();
        $this->tasks = factory(Task::class, 10)->create();
    }

    /**
     * Tests that all users are on the url tasks.
     *
     * @return void
     */
    public function testIndex()
    {
        $response = $this->get('/tasks');
        $response->assertStatus(200);
        $response->assertViewIs('tasks.index');
        $response->assertViewHas('storedTasks');

        foreach ($this->tasks as $task) {
            $this->assertDatabaseHas('tasks', $task->toArray());
        }
    }

    /**
     * Test that you can edit a user.
     *
     * @return void
     */
    public function testEdit()
    {
        foreach ($this->tasks as $task) {
            $response = $this->get('/tasks/' . $task->id . '/edit');
            $response->assertStatus(200);
            $response->assertViewIs('tasks.edit');
            $response->assertViewHas('task');
            $response->assertOk();
            $response->assertSee($task->name);
        }
    }

    /**
     * Tests that you can add a new task.
     *
     * @return void
     */
    public function testStore()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        $response = $this->post('/tasks', ['newTaskName' => 'newNameName']);
        $response->assertRedirect('/tasks');
        $response->assertSessionHas(['success_created']);
        $this->assertDatabaseHas('tasks', ['name' => 'newNameName']);
    }


    /**
     * Tests that you can update a task.
     *
     * @return void
     */
    public function testUpdate()
    {
        $this->withoutMiddleware(VerifyCsrfToken::class);
        foreach ($this->tasks as $task) {
            $response = $this->put("/tasks/" . $task->id, ['updatedName' => 'newNameName']);
            $response->assertRedirect('/tasks');
            $response->assertSessionHas(['success_updated']);
            $this->assertDatabaseHas('tasks', ['name' => 'newNameName']);
        }
    }


    /**
     * Tests that you can delete task.
     *
     * @return void
     */
    public function testDelete()
    {
        foreach ($this->tasks as $task) {
            $response = $this->delete("/tasks/" . $task->id);
            $response->assertRedirect('/tasks');
            $response->assertSessionHas(['success_deleted']);
        }
    }
}
