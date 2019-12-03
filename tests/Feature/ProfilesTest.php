<?php

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProfilesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = create(User::class);
    }

    /** @test */
    public function test_a_user_has_a_profile()
    {
        $this->get(route('profiles.show', $this->user->name))
            ->assertSee($this->user->name);
    }

    /** @test */
    public function test_a_profile_displays_all_threads_of_the_associated_user()
    {
        create(Thread::class, ['user_id' => $this->user->id], 5);
        $threads = Thread::where('user_id', $this->user->id)->get();

        foreach ($threads as $thread) {
            $this->get(route('profiles.show', $this->user->name))
                ->assertSee($thread->title)
                ->assertSee($thread->body);
        }
    }
}
