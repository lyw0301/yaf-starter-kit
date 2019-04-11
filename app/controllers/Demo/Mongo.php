<?php

/**
 * class Demo_MongoController.
 *
 * @author lyw0301 <451691564@qq.com>
 */
class Demo_MongoController extends BaseController
{
    public function handle()
    {
        // 连接
        $uri = "mongodb://root:root@localhost:27017";
        $client = new MongoDB\Client($uri);
        $collection = $client->demo->website;

        // 插入操作
        $result = $collection->insertOne([
            'name' => 'MongoChina',
            'url' => 'http://www.mongochina.com',
        ]);
        echo "Inserted with Object ID '{$result->getInsertedId()}'";

        // 获取结果
        $result = $collection->find()->toArray();
        print_r($result);
    }
}
