<?php

namespace Tests\Unit;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_has_an_owner()
    {
        $reply = factory('App\Reply')->create();
        $this->assertInstanceOf(User::class, $reply->owner);
    }
}
