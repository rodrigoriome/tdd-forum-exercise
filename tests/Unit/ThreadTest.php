<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    public function test_a_thread_can_make_a_string_path()
    {
        $this->assertEquals("/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }

    public function test_a_thread_has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->user);
    }

    public function test_a_thread_can_have_replies()
    {
        $this->assertInstanceOf(Collection::class, $this->thread->replies);
    }

    public function test_a_thread_can_add_a_reply()
    {
        $this->thread->addReply([
            'body' => 'Foobar',
            'user_id' => 1,
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    public function test_a_thread_belong_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }
}
