<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MakeTestCommand
 * @package App\Commands
 */
class MakeTestCommand extends Command
{
    use Traits\ControllerNameParserTrait, Traits\GitUserTrait, Traits\TemplateRenderTrait;

    protected $name = 'make:test';
    protected $description = '创建测试文件';
    protected $arguments = [
        ['controller', InputArgument::OPTIONAL, '控制器类名：Users_UpdateController（可以省掉最后的Controller后缀）'],
    ];

    public function handle()
    {
        $controller = $this->formatControllerName($this->argument('controller'));

        $replacements = [
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'controller' => $controller,
        ];

        $file = BASE_PATH.'/tests/controllers/'.str_replace(['_', 'Controller'], ['/', ''], $controller).'Test.php';

        $this->renderAndSave('test', $replacements, $file);

        exec('composer dump');
    }
}
