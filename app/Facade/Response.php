<?php

namespace App\Facade;

class Response {

    public static function resolveFacade($name) {
        return app()[$name];
    }

    public static function __callStatic($method, $arguments)
    {
        return (self::resolveFacade("Response"))
            ->$method(...$arguments);
    }
}