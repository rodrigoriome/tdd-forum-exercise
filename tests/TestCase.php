<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Utils\ExceptionHandler;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication, ExceptionHandler;

    protected function setUp(): void
    {
        parent::setUp();
        $this->disableExceptionHandling();
    }

    protected function signIn($user = null)
    {
        $user = $user ?: create(\App\User::class);

        $this->actingAs($user);

        return $user;
    }
}
