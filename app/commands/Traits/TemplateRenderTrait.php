<?php

namespace App\Commands\Traits;

/**
 * Trait TemplateRenderTrait
 * @package App\Commands\Traits
 */
trait TemplateRenderTrait
{
    /**
     * @param string $name
     * @param array  $data
     *
     * @return mixed
     */
    public function renderTemplate($name, $data)
    {
        $template = file_get_contents(__DIR__.'/../stubs/'.$name.'.stub');

        $search = array_map(function ($item) {
            return '{{'.$item.'}}';
        }, array_keys($data));

        $content = str_replace($search, $data, $template);

        return $content;
    }

    /**
     * @param string $name
     * @param array  $data
     * @param string $file
     */
    public function renderAndSave($name, $data, $file)
    {
        $baseFile = str_replace(BASE_PATH, '', $file);

        if (file_exists($file) && !$this->confirm("文件 $baseFile 已经存在，是否覆盖？", false)) {
            $this->abort('Abort.');
        }

        if (!is_dir(dirname($file))) {
            mkdir(dirname($file), 0755, true);
        }

        file_put_contents($file, $this->renderTemplate($name, $data));

        $this->info($file.' Created!');
    }
}
