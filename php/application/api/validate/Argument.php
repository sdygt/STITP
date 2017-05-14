<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2017/3/18
 * Time: 20:31
 */

namespace app\api\validate;

use think\Validate;

class Argument extends Validate
{
    protected $rule = [
        'direction' => 'require|in:Bwd,Fwd',
        'code'      => 'require'
    ];
}