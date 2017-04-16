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
        'm' => 'require|in:Symbolic,Weiser,SDG,IFDS',
        'd' => 'require|in:Bwd,Fwd,Both'
    ];
}