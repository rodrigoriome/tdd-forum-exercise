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
        $this->post(route('replies.store', [
            $thread->channel,
            $thread,
        ]), $reply)
            ->assertRedirect(route('login'));
    }

    /** @test */
    public function test_guests_may_not_delete_replies()
    {
        $this->withExceptionHandling();

        $reply = create(Reply::class);

        $this->delete(route('replies.destroy', $reply->id))
            ->assertRedirect(route('login'));

        $this->signIn();
        $this->delete(route('replies.destroy', $reply->id))
            ->assertStatus(403);
    }

    /** @test */
    public function test_authorized_users_can_delete_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete(route('replies.destroy', $reply->id))->assertStatus(302);

        $this->assertDatabaseMissing('replies', ['id' => $reply->id]);
    }

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        // Given we have a authenticated user
        $this->signIn();

        // When we hit the endpoint to submit a reply on a thread
        $thread = create(Thread::class);
        $reply = make(Reply::class);
        $this->post(route('replies.store', [$thread->channel, $thread]), $reply->toArray());

        // Then we should see our reply on that thread
        $this->get($thread->path())
            ->assertSee($reply->body);
    }

    public function test_a_reply_has_a_valid_body()
    {
        $this->signIn();
        $this->withExceptionHandling();

        $thread = create(Thread::class);
        $reply = make(Reply::class, ['body' => null]);

        $this->post(route('replies.store', [$thread->channel, $thread]), $reply->toArray())
            ->assertSessionHasErrors('body');
    }
}
