<?php

use App\Activity;
use App\Reply;
use App\Thread;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ActivityTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_it_records_activity_when_a_thread_is_created()
    {
        $this->signIn();

        $thread = create(Thread::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_thread',
            'user_id' => auth()->id(),
            'subject_id' => $thread->id,
            'subject_type' => Thread::class,
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $thread->id);
    }

    /** @test */
    public function test_it_records_activity_when_a_reply_is_created()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->assertDatabaseHas('activities', [
            'type' => 'created_reply',
            'user_id' => auth()->id(),
            'subject_id' => $reply->id,
            'subject_type' => Reply::class,
        ]);

        $this->assertEquals(2, Activity::count());
    }

    /** @test */
    public function test_it_fetches_a_feed_for_a_user()
    {
        $this->signIn();

        // Given we have a recent thread
        $recentThread = create(Thread::class, ['user_id' => auth()->id()]);

        // And a thread from a week ago
        $pastThread = create(Thread::class, [
            'user_id' => auth()->id(),
            'created_at' => Carbon::now()->subWeek(),
        ]);

        /*
         * For testing purposes only, as the activity is always recorded as created at the current time, ignoring
         * the Carbon subweek timestamp.
         */
        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        // When we fetch their feed
        $feed = Activity::feed(auth()->user());

        // Then it should be returned in the proper format
        $this->assertCount(2, $feed);
        $this->assertContains(Carbon::now()->format('Y-m-d'), $feed->keys());
        $this->assertContains(Carbon::now()->subWeek()->format('Y-m-d'), $feed->keys());
    }
}
