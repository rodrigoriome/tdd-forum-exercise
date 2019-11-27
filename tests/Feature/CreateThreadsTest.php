<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_an_authenticated_user_can_create_threads()
    {
        // Given we have a signed in user
        $user = factory(User::class)->create();
        $this->actingAs($user);

        // When we hit the endpoint to create a new thread
        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());

        // Then we should see the new thread on that thread page
        $this->get('/threads')
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    public function test_guests_may_not_create_threads()
    {
        $this->expectException(AuthenticationException::class);

        $thread = factory(Thread::class)->make();
        $this->post('/threads', $thread->toArray());
    }
}
