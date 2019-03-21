<?php

/**
 * class Log.
 *
 * 注意：默认使用 User::id() 作为行为日志（action log）uid 的参数值！
 *     除了特殊的情况，不需要自行传递 uid 参数，或使用函数 actionWithUid()！
 *
 * @method static void action(int $id, $oid = null, array|string $ext = '')
 * @method static void actionWithUid(int $id, $oid, $uid, $ext = '')
 * @method static void write(string $module, $message, array $context = [])
 * @method static void save()
 */
class Log extends Facade
{
    /**
     * {@inheritdoc}
     */
    protected static function getFacadeAccessor()
    {
        return \App\Services\Logger::class;
    }
}
