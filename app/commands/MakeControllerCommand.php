<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

/**
 * Class MakeControllerCommand
 * @package App\Commands
 */
class MakeControllerCommand extends Command
{
    use Traits\ControllerNameParserTrait, Traits\GitUserTrait, Traits\TemplateRenderTrait;

    protected $name = 'make:controller';
    protected $description = '创建控制器与测试文件';
    protected $arguments = [
        ['name', InputArgument::OPTIONAL, '控制器类名：Users_UpdateController（可以省掉最后的Controller后缀）'],
    ];
    protected $options = [
      ['no-test', true, InputOption::VALUE_NONE, '不生成测试文件'],
    ];

    public function handle()
    {
        $controller = $this->formatControllerName($this->argument('name'));

        $replacements = [
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'controller' => $controller,
        ];

        $file = BASE_PATH.'/app/controllers/'.str_replace(['_', 'Controller'], ['/', ''], $controller).'.php';

        $this->renderAndSave('controller', $replacements, $file);

        /*
        if (!$this->option('no-test')) {
            $this->call('make:test', ['controller' => $controller]);
        }
        */

        exec('composer dump');
    }
}
