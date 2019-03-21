<?php

namespace App\Commands\Traits;

/**
 * Trait ControllerNameParserTrait
 * @package App\Commands\Traits
 */
trait ControllerNameParserTrait
{
    /**
     * @param string $controller
     *
     * @return mixed
     */
    protected function formatControllerName($controller)
    {
        $replacements = [
            ' ' => '',
            '/' => ' ',
            '_' => ' ',
            'Controller' => '',
        ];

        $controller = str_replace(array_keys($replacements), $replacements, trim($controller));

        $controller = preg_replace_callback('/([^_\s])([A-Z])/', function ($matches) {
            return $matches[1].' '.$matches[2];
        }, $controller);

        return str_replace(' ', '_', ucwords($controller.'Controller'));
    }
}
