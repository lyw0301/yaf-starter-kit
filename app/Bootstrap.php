<?php

use Yaf\Bootstrap_Abstract as YafBootstrap;
use Yaf\Dispatcher;
use \App\Services\Register;
use Illuminate\Events\Dispatcher as LDispatcher;
use Illuminate\Container\Container as LContainer;
use Illuminate\Database\Capsule\Manager as Capsule;


/**
 * Class Bootstrap
 */
class Bootstrap extends YafBootstrap
{
    /**
     * @var Register
     */
    protected $register;

    /**
     * 项目基本初始化操作.
     *
     * @param Dispatcher $dispatcher
     */
    public function _initProject(Dispatcher $dispatcher)
    {
        date_default_timezone_set('PRC');
        $dispatcher->returnResponse(true);
        $dispatcher->disableView();
    }

    /**
     * autoload.
     *
     * @param Dispatcher $dispatcher [description]
     */
    public function _initLoader(Dispatcher $dispatcher)
    {
        $loader = \Yaf\Loader::getInstance();
        $loader->import(ROOT_PATH.'/vendor/autoload.php');
    }

    /**
     * init container
     * @param Dispatcher $dispatcher
     */
    public function _initContainer(Dispatcher $dispatcher)
    {
        // init Container
        $this->register = $register = new Register();
        $register->set(Register::class, $register);
        $register->alias('services.register', $register);
    }

    /**
     * init Facade
     *
     * @param Dispatcher $dispatcher
     */
    public function _initFacade(Dispatcher $dispatcher)
    {
        // inject Register Container
        Facade::init($this->register);
    }

    /**
     * @param \Yaf\Dispatcher $dispatcher
     *
     * @throws \App\Exceptions\ErrorException
     */
    public function _initConfig(Dispatcher $dispatcher)
    {
        $this->config = \Yaf\Application::app()->getConfig();//把配置保存起来
        Config::createFromPath(ROOT_PATH.'/config');
    }

    /**
     * 日志启动器.
     *
     * @param Dispatcher $dispatcher
     */
    public function _initLogger(Dispatcher $dispatcher)
    {
        $log = new \App\Services\Logger('yaf');

        // 请自己配置日志
        //$log->setHandlers();

        $this->register->set(\App\Services\Logger::class, $log);
        $this->register->alias('services.log', $log);
    }

    /**
     * 注册插件.
     *
     * @param Dispatcher $dispatcher
     */
    public function _initPlugins(Dispatcher $dispatcher)
    {
        if ($this->env() === 'dev') {
            // 只有在 dev 环境下可以在 URL 里模拟产品环境返回值
            if (Request::get('__env') == 'pro') {
                putenv('APP_ENV=pro');
                $dispatcher->registerPlugin(new ExceptionHandlerPlugin());
            } elseif (class_exists('Whoops\Run')) {
                $dispatcher->registerPlugin(new DevHelperPlugin());
            }
        } else {
            $dispatcher->registerPlugin(new ExceptionHandlerPlugin());
        }

        $dispatcher->registerPlugin(new ViewRenderPlugin());
    }

    /**
     * 初始化 Eloquent ORM
     *
     * @param Dispatcher $dispatcher
     */
    public function _initDefaultDbAdapter(Dispatcher $dispatcher)
    {
        $capsule = new Capsule();
        $capsule->addConnection($this->config->database->toArray());
        $capsule->setEventDispatcher(new LDispatcher(new LContainer));
        $capsule->setAsGlobal();
        $capsule->bootEloquent();

        class_alias('\Illuminate\Database\Capsule\Manager', 'DB');
    }

    /**
     * 获取环境.
     *
     * @return string
     */
    public function env()
    {
        return getenv('APP_ENV') ?: 'dev';
    }
}
