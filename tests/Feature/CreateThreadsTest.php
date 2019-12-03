<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_may_not_create_threads()
    {
        $this->withExceptionHandling();
        $thread = make(Thread::class)->toArray();

        $this->post(route('threads.store'), $thread)
            ->assertRedirect(route('login'));

        $this->get(route('threads.create'))
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function test_guests_may_not_delete_threads()
    {
        $this->withExceptionHandling();

        $thread = create(Thread::class);

        $this->deleteThread($thread)->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_create_threads()
    {
        // Given we have a signed in user
        $this->signIn();

        // When we hit the endpoint to create a new thread
        $thread = make(Thread::class);
        $this->post(route('threads.store'), $thread->toArray());

        // Then we should see the new thread on that thread page
        $this->get(route('threads.index'))
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

    /** @test */
    public function test_a_thread_can_be_deleted()
    {
        $this->signIn();

        // Given we have a thread
        $thread = create(Thread::class);

        // And it's present in the database
        $this->assertDatabaseHas('threads', $thread->toArray());

        // When we hit the endpoint to delete that thread
        $this->deleteThread($thread);

        // It should not exist on database
        $this->assertDatabaseMissing('threads', ['id' => $thread->id]);
    }

    /** @test */
    // public function test_a_thread_may_only_be_deleted_by_those_who_have_permission()
    // {
    //     // TODO:
    // }

    /** @test */
    public function test_all_thread_replies_are_deleted_upon_thread_deletion()
    {
        $this->signIn();

        // Given we have a thread with replies
        $thread = create(Thread::class);
        $reply = create(Reply::class, ['thread_id' => $thread->id]);

        // When we delete that thread
        $this->delete(route('threads.destroy', [
            $thread->channel,
            $thread,
        ]));

        // Then none of the associated replies should exist on database
        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_a_thread_require_a_valid_title()
    {
        $this->publishThread(['title' => null])
            ->assertSessionHasErrors('title');
    }

    public function test_a_thread_require_a_valid_body()
    {
        $this->publishThread(['body' => null])
            ->assertSessionHasErrors('body');
    }

    public function test_a_thread_require_a_valid_channel()
    {
        factory(Channel::class, 2)->create();

        // Assert it is required
        $this->publishThread(['channel_id' => null])
            ->assertSessionHasErrors('channel_id');

        // Assert the given channel exists
        $this->publishThread(['channel_id' => 999])
            ->assertSessionHasErrors('channel_id');
    }

    private function publishThread(array $overrides = [])
    {
        $this->signIn();
        $this->withExceptionHandling();
        $thread = make(Thread::class, $overrides)->toArray();

        $request = $this->post(route('threads.store'), $thread);

        return $request;
    }

    public function deleteThread(Thread $thread)
    {
        return $this->delete(route('threads.destroy', [
            $thread->channel,
            $thread,
        ]));
    }
}
