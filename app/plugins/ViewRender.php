<?php

use League\Plates\Engine;
use Yaf\Plugin_Abstract as YafPlugin;
use Yaf\Request_Abstract as YafRequest;
use Yaf\Response_Abstract as YafResponse;

/**
 * Class ViewRenderPlugin
 */
class ViewRenderPlugin extends YafPlugin
{
    /**
     * 注册模板引擎.
     *
     * @param \Yaf\Request_Abstract  $request
     * @param \Yaf\Response_Abstract $response
     */
    public function routerStartup(YafRequest $request, YafResponse $response)
    {
        class_exists('League\Plates\Engine') && $this->registerPlates();
    }

    /**
     * Register Plates Engine.
     */
    public function registerPlates()
    {
        $plates = new Engine(APP_PATH.'/views');

        Registry::set('services.view', $plates);
    }
}
