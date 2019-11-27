<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_may_not_create_threads()
    {
        $this->expectException(AuthenticationException::class);
        $thread = make(Thread::class)->toArray();
        $this->post('/threads', $thread);
    }

    public function test_an_authenticated_user_can_create_threads()
    {
        // Given we have a signed in user
        $this->signIn();

        // When we hit the endpoint to create a new thread
        $thread = make(Thread::class);
        $this->post('/threads', $thread->toArray());

        // Then we should see the new thread on that thread page
        $this->get('/threads')
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
