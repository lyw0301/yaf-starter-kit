<?php

namespace App\Commands;

use Symfony\Component\Console\Input\InputArgument;

/**
 * Class MakeTraitTestCommand
 * @package App\Commands
 */
class MakeTraitTestCommand extends Command
{
    use Traits\GitUserTrait, Traits\TemplateRenderTrait;

    protected $name = 'make:test_trait';
    protected $description = '创建 Trait 的测试文件';
    protected $arguments = [
        ['trait', InputArgument::OPTIONAL, 'trait 类名：App\Traits\AppApi（可以省掉前面的 App\Traits）'],
    ];

    public function handle()
    {
        $trait = $this->formatTraitName($this->argument('trait'));

        $parts = explode('\\', $trait);

        $replacements = [
            'username' => $this->getUsername(),
            'email' => $this->getEmail(),
            'trait' => end($parts),
            'trait_fullname' => $trait,
        ];

        $filename = str_replace('\\', '/', str_replace('App\Traits\\', '', $trait)).'Test.php';

        $file = BASE_PATH."/tests/traits/{$filename}";

        $this->renderAndSave('trait', $replacements, $file);

        exec('composer dump');
    }

    /**
     * 格式化输入的 trait 名称.
     *
     * @param string $name
     *
     * @return string
     */
    public function formatTraitName($name)
    {
        $replacements = [
            '_' => ' ',
            '\\' => ' ',
        ];

        $name = str_replace(array_keys($replacements), $replacements, $name);
        $name = trim(str_replace(' ', '\\', ucwords($name)), '\\');
        $name = str_replace('App\Traits\\', '', $name);

        return 'App\Traits\\'.$name;
    }
}
