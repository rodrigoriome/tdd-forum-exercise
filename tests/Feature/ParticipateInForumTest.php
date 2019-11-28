<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);

        $thread = create(Thread::class);
        $reply = create(Reply::class)->toArray();
        $this->post(route('reply.store', [
            $thread->channel,
            $thread
        ]), $reply)
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        $this->signIn();

        // When we hit the endpoint to submit a reply on a thread
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $this->post(route('reply.store', [
            $thread->channel,
            $thread,
        ]), $reply->toArray());

        // Then we should see our reply on that thread
        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
