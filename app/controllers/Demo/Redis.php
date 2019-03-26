<?php

/**
 * class Demo_RedisController.
 *
 * @author lyw0301 <451691564@qq.com>
 */
class Demo_RedisController extends BaseController
{
    public function handle()
    {
       $redis = new Predis\Client([
           'scheme' => 'tcp',
           'host'   => '127.0.0.1',
           'port'   => 6379,
       ]);

       print_r($redis->info());
    }
}
