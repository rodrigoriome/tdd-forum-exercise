<?php

namespace App;

trait Favoritable
{
    public function favorites()
    {
        return $this->morphMany(Favorite::class, 'favorited');
    }

    public function isFavoritedByUser()
    {
        return !!$this
            ->favorites()
            ->where(['user_id' => auth()->id()])
            ->count();
    }

    public function getIsFavoritedAttribute()
    {
        return $this->isFavoritedByUser();
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites->count();
    }

    public function favorite()
    {
        $attributes = ['user_id' => auth()->id()];

        if (!$this->favorites()->where($attributes)->exists()) {
            return $this->favorites()->create($attributes);
        }
    }

    public function unfavorite()
    {
        $reply = $this->favorites()->where('user_id', auth()->id());

        if ($reply->exists()) {
            $reply->delete();
        }
    }
}
