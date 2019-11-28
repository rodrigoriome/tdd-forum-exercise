<?php

namespace Tests\Utils;

use App\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler as BaseExceptionHandler;

trait ExceptionHandler
{
    protected function disableExceptionHandling()
    {
        $this->oldExceptionHandler = $this->app->make(BaseExceptionHandler::class);
        $this->app->instance(BaseExceptionHandler::class, new class extends Handler {
            public function __construct()
            {
            }

            public function report(\Exception $e)
            {
            }

            public function render($request, \Exception $e)
            {
                throw $e;
            }
        });
    }

    protected function withExceptionHandling()
    {
        $this->app->instance(BaseExceptionHandler::class, $this->oldExceptionHandler);

        return $this;
    }
}
