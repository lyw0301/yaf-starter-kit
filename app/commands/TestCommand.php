<?php

namespace App\Commands;

use Symfony\Component\Process\Process;

/**
 * Class TestCommand
 * @package App\Commands
 */
class TestCommand extends Command
{
    protected $name = 'test';
    protected $description = '运行单元测试.';

    /**
     * TestCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->ignoreValidationErrors();
    }

    /**
     * @return int|void
     */
    public function handle()
    {
        $phpunit = BASE_PATH.'/vendor/bin/phpunit';

        if (!file_exists($phpunit)) {
            return $this->error('请先安装依赖：composer install -vvv');
        }

        $process = new Process("composer dump && $phpunit -d memory_limit=1024M ".$this->getCommandLine(true));

        return $process->setTimeout(360)->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });
    }
}
