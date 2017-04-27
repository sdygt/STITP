<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2017/3/18
 * Time: 16:10
 */

namespace app\api\controller\Exception;


use think\Exception;

class InvalidSlicingArgumentException extends Exception
{
    public function __construct($message, $code = 0, Exception $previous = null)
    {

        parent::__construct($message, $code, $previous);
    }

    // 自定义字符串输出的样式
    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}