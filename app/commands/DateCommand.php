<?php
/**
 * Created by PhpStorm.
 * User: liuyiwei@7659.com
 */

namespace App\Commands;


class DateCommand extends Command
{
    protected $name = 'date';
    protected $description = '测试测试！';

    public function handle() {
        $this->info(date("Y-m-d H:i:s"));
    }
}