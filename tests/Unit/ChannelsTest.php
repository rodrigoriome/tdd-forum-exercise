<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Database\Eloquent\Collection;

class ChannelsTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_channel_can_have_threads()
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel->id]);

        $this->assertTrue($channel->threads->contains($thread));
        $this->assertInstanceOf(Collection::class, $channel->threads);
    }
}
