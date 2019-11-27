<?php

namespace Tests\Feature;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    use RefreshDatabase;

    public function test_unauthenticated_users_may_not_add_replies()
    {
        $this->expectException(AuthenticationException::class);
        $this->post('/threads/1/replies', []);
    }

    public function test_an_authenticated_user_may_participate_in_forum_threads()
    {
        $user = factory('App\User')->create();
        $thread = factory('App\Thread')->create();
        $reply = factory('App\Reply')->make();

        $this->be($user);
        $this->post($thread->path() . '/replies', $reply->toArray());

        $this->get($thread->path())
            ->assertSee($reply->body);
    }
}
