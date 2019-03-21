<?php

namespace App\Services\Http\Traits;

/**
 * Trait InputCastedAccessor
 * @package App\Services\Http\Traits
 */
trait InputCastedAccessor
{
    /**
     * 获取 int 型参数.
     *
     * @param int $key
     * @param int $default
     *
     * @return int
     */
    public function int($key, $default = null)
    {
        return intval($this->get($key, $default));
    }

    /**
     * 获取 float 型参数.
     *
     * @param string $key
     * @param null   $default
     *
     * @return float
     */
    public function float($key, $default = null)
    {
        return floatval($this->get($key, $default));
    }

    /**
     * 将参数转成 bool.
     *
     * @param string $key
     * @param bool   $toInt
     * @param mixed  $default
     *
     * @return bool|int
     */
    public function bool($key, $toInt = false, $default = null)
    {
        $bool = (bool) $this->get($key, $default);

        return $toInt ? intval($bool) : $bool;
    }

    /**
     * 将输入的值转为整型的 0/1.
     *
     * @param string $key
     * @param null   $default
     *
     * @return bool|int
     */
    public function bool2Int($key, $default = null)
    {
        return $this->bool($key, true, $default);
    }

    /**
     * 获取参数的绝对值
     *
     * @param int $key
     * @param int $default
     *
     * @return int
     */
    public function abs($key, $default = null)
    {
        return abs($this->get($key, $default));
    }
}
