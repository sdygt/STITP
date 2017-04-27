<?php

namespace app\api\controller;


use app\api\controller\Exception\InvalidSlicingArgumentException;
use app\api\model\Source;
use think\Controller;
use think\Loader;
use think\Request;

class phpapi extends Controller
{
    private $arg = ['m' => null, 'd' => null, 'c' => null];

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

    }

    public function slice()
    {
        $this->arg['m'] = input('post.arg_m');
        $this->arg['d'] = input('post.arg_d');
        $this->arg['c'] = input('post.arg_c');

        $validate = Loader::validate('Argument');
        if ( !$validate->check($this->arg)) {
            throw new InvalidSlicingArgumentException('Invalid Argument(s)');
        }
        $file = new Source(request()->file('file-0'));

        if ($file->checkSyntax()->getRet() !== 0) {
            $this->result($file->getStdout(), $file->getRet(), 'Syntax Error');
        }

        $file->setArg($this->arg)->slice();
        $this->result($file->getSliceData(), 0, 'Slice Success');
    }

    public function call_graph()
    {
        $file = new Source(request()->file('file-0'));
        $svg = $file->call_graph()->getStdout();
        header("Content-Type: image/svg+xml;charset=utf-8");
        echo $svg;
        return;
    }

}