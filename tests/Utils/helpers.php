<?php

use Illuminate\Database\Eloquent\Collection;

function create($class, $attributes = [])
{
    return factory($class)->create($attributes);
}

function make($class, $attributes = [])
{
    return factory($class)->make($attributes);
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
