<?php

use App\Support\Collection;

/**
 * Class Config
 */
class Config
{
    /**
     * @param string $name
     * @param null   $default
     *
     * @return mixed
     */
    public static function get(string $name, $default = null)
    {
        return Registry::get('services.config')->get($name) ?? $default;
    }

    /**
     * @param string $name
     *
     * @return bool
     */
    public static function has(string $name)
    {
        return Registry::get('services.config')->has($name) ?? false;
    }

    /**
     * @param string $path
     *
     * @throws \App\Exceptions\ErrorException
     */
    public static function createFromPath(string $path)
    {
        if (!is_dir($path) || !is_readable($path)) {
            abort('配置文件目录不存在');
        }

        $collection = new Collection();

        foreach (glob(rtrim($path, '/').'/*') as $file) {
            $collection->set(basename(str_replace('.ini', '', $file)), parse_ini_file($file));
        }

        Registry::set('services.config', $collection);
    }
}
