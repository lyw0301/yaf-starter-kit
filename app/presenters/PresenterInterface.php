<?php

namespace App\Presenters;

use ArrayAccess;
use JsonSerializable;

/**
 * Interface PresenterInterface.
 */
interface PresenterInterface extends JsonSerializable, ArrayAccess
{
    /**
     * 处理展示数据,去除不需要的数据.
     *
     * @return array
     */
    public function present();

    /**
     * 返回数组结构.
     *
     * @return array
     */
    public function toArray();
}
