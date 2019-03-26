<?php

/**
 * Class IndexController
 */
class IndexController extends BaseController
{
    /**
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function handle()
    {
        return view('welcome', ['name'=>'Yaf starter kit']);
    }
}
