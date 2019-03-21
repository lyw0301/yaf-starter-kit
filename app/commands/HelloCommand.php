<?php

namespace App\Commands;

/**
 * Class HelloCommand
 * @package App\Commands
 */
class HelloCommand extends Command
{
    protected $name = 'hello';
    protected $description = '输出 Hello.';

    public function handle()
    {
        $this->info('Hello world!');
    }
}
