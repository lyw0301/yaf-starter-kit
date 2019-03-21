<?php

/**
 * Class Cache.
 *
 * @method static \App\Services\Throttle make(string $key, int $limit, int $time);
 */
class Throttle extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return App\Services\ThrottleFactory::class;
    }
}
