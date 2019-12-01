<?php

use Illuminate\Database\Eloquent\Collection;

function create($class, $attributes = [], $times = null)
{
    return factory($class, $times)->create($attributes);
}

function make($class, $attributes = [], $times = null)
{
    return factory($class, $times)->make($attributes);
}

function getSessionError(string $errName)
{
    return new Collection(
        app('session.store')
            ->get('errors')
            ->getBag('default')
            ->get($errName)
    );
}
