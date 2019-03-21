<?php

namespace App\Commands;

use Symfony\Component\Process\Process;

/**
 * Class CodeBeautifierAndFixerCommand
 * @package App\Commands
 */
class CodeBeautifierAndFixerCommand extends Command
{
    protected $name = 'cbf';
    protected $description = '修复代码规范.';

    /**
     * CodeBeautifierAndFixerCommand constructor.
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
        $phpcbf = BASE_PATH.'/vendor/bin/phpcbf';

        if (!file_exists($phpcbf)) {
            return $this->error('请先安装依赖：composer install -vvv');
        }

        $suffix = $this->getCommandLine(true);

        if (empty($suffix)) {
            $suffix = './app';
        }

        $commands = [
            "$phpcbf --ignore=app/Bootstrap.php,app/Commands/ $suffix",
        ];

        $this->output->write("<info>processing...</info>\n");

        $process = new Process(join(' && ', $commands));

        $exitCode = $process->setTimeout(360)->run(function ($type, $buffer) {
            $this->output->write($buffer);
        });

        if (!$exitCode) {
            $this->output->write("<info>Good job!</info>\n");
        }

        return $exitCode;
    }
}
