<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReadThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    public function test_a_user_can_view_all_threads()
    {
        $this->get('/threads')
            ->assertStatus(200)
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertStatus(200)
            ->assertSee($this->thread->title);
    }

    public function test_a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // Given a thread with replies
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

        // When we visit that thread's page
        $reponse = $this->get($this->thread->path());

        // Then we should see the replies of that thread
        $reponse->assertSee($reply->body);
    }
}
