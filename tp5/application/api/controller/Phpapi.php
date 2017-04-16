<?php

namespace app\api\controller;


use app\api\controller\Exception\InvalidSlicingArgumentException;
use app\api\model\Source;
use think\Controller;
use think\Loader;

class phpapi extends Controller
{
    public function slice_dispatcher()
    {
        $arg['m'] = input('post.arg_m');
        $arg['d'] = input('post.arg_d');
        $arg['c'] = input('post.arg_c');

        $validate = Loader::validate('Argument');
        if ( !$validate->check($arg)) {
            throw new InvalidSlicingArgumentException('Invalid Argument(s)');
        }

        $file = new Source(request()->file('file-0'));

        if ($file->checkSyntax()->getRet() !== 0) {
            $this->result($file->getStdout(), $file->getRet(), 'Syntax Error');
        }

        $file->setArg($arg)->slice();
        $this->result($file->getSliceData(), 0, 'Slice Success');
    }

}