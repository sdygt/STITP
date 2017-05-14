<?php

namespace app\api\controller;


use app\api\controller\Exception\InvalidSlicingArgumentException;
use app\api\model\Source;
use think\Controller;
use think\Loader;
use think\Request;

class phpapi extends Controller
{
    private $arg = ['direction' => null, 'code' => null];

    public function __construct(Request $request = null)
    {
        parent::__construct($request);

    }

    public function slice()
    {
        $reqJson = json_decode(file_get_contents("php://input"), true);
        $this->arg['direction'] = $reqJson['direction'];
        $this->arg['code'] = $reqJson['code'];


        $validate = Loader::validate('Argument');
        if ( !$validate->check($this->arg)) {
            throw new InvalidSlicingArgumentException('Invalid Argument(s)');
        }
        $source = new Source($this->arg);
        if ($source->checkSyntax()->getRet() !== 0) {
            return json_encode(['error' => $source->getStdout(), '__hash__' => $source->getHash()]);
        }


        $source->slice();

        return json_encode($source->getSliceData() + ['__hash__' => $source->getHash()]);

    }

    public function call_graph()
    {
        $reqJson = json_decode(file_get_contents("php://input"), true);
        $file = new Source(['code' => $reqJson, 'direction' => null]);
        $svg = $file->call_graph()->getStdout();
        return json_encode($svg);
    }

}