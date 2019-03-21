<?php

use Yaf\Registry as YafRegistry;

/**
 * class Registry.
 *
 * @method static get(string $name): mixed
 * @method static set(string $name, mixed $instance): mixed
 * @method static has(string $name): bool
 */
class Registry extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @throws \RuntimeException
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'services.register';
    }
}
