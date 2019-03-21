<?php
/**
 * Created by PhpStorm.
 * User: liuyiwei@zhizhudj.com
 * Date: 2019/3/21
 * Time: 16:08
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DlbOrder extends Model
{
    protected $table = 'dalaba_order';
    const UPDATED_AT = 'updated';
}