<?php

namespace Tests\Feature;

use App\Favorite;
use App\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoritesTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_may_not_favorite_replies()
    {
        $this->withExceptionHandling()
            ->post(route('favorites.store', 1))
            ->assertRedirect(route('login'));
    }

    public function test_an_authenticated_user_can_favorite_replies()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $this->post(route('favorites.store', $reply->id));

        $this->assertCount(1, $reply->favorites);
        $this->assertInstanceOf(Favorite::class, $reply->favorites->first());
    }

    public function test_an_authenticated_user_may_only_favorite_a_reply_once()
    {
        $this->signIn();
        $reply = create(Reply::class);

        try {
            $this->post(route('favorites.store', $reply->id));
            $this->post(route('favorites.store', $reply->id));
        } catch (\Exception $e) {
            $this->fail('Did not expect to insert the same record set twice.');
        }

        $this->assertCount(1, $reply->favorites);
    }

    public function test_a_reply_can_be_unfavorited()
    {
        // Given we have a reply with 1 favorite
        $this->signIn();
        $reply = create(Reply::class);
        $this->post(route('favorites.store', $reply->id));

        // When we hit the endpoint to remove that favorite
        $this->delete(route('favorites.destroy', $reply->id));

        // Then the reply should have no favorites
        $this->assertCount(0, $reply->favorites);
    }
}
