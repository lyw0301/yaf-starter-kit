<?php
use \App\Models\DlbOrder;

/**
 * class IndexController.
 *
 * @author overtrue <i@overtrue.me>
 */
class IndexController extends BaseController
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle()
    {
        $data = DlbOrder::query()
            ->find(1)
            ->toArray();

        $data = DlbOrder::query()
            ->where(['match_id'=>103681])
            ->limit(2)
            ->get()
            ->toArray();

        $model = DlbOrder::query()->find(1);
        $model->msg = 'test';
        $model->saveOrFail();

        print_r($model);
    }
}
