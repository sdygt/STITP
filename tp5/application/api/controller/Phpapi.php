<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2016/10/2
 * Time: 21:13
 */

namespace app\api\controller;


use app\api\controller\Parser\Parser;
use think\Controller;


class phpapi extends Controller
{
    public function CheckSyntax()
    {
        $file = request()->file('file-0');

        if ($file) {
            $info = $file->rule(function ($file) {
                return substr($file->hash('md5'), 0, 8) . '_' . preg_replace('/\h+/', '_', $file->getInfo('name'));
            })->move('/tmp' . DS . 'stitp');
            $pathname = $info->getPathname();
        } else {
            return ['status' => false];
        }

        ob_start();
        passthru('clang -fsyntax-only ' . '"' . $pathname . '"' . ' 2>&1', $ret);
        $stdout = ob_get_clean();
        if ($ret === 0) {
            return ['status' => true, 'message' => 'Syntax check successful'];
        } else {
            return ['status' => true, 'message' => $stdout];
        }
    }

    public function LLVMSlice_All()
    {
        $arg_m = input('post.arg_m');
        $arg_d = input('post.arg_d');

        if ( !in_array($arg_d, ['Bwd', 'Fwd', 'Both'])) {
            $arg_d = 'Bwd';
        }
        if ( !in_array($arg_m, ['Symbolic', 'Weiser', 'SDG', 'IFDS'])) {
            $arg_m = 'Symbolic';
        }

        $file = request()->file('file-0');
        if ($file) {
            $info = $file->rule(function ($file) {
                return substr($file->hash('md5'), 0, 8) . '_' . preg_replace('/\h+/', '_', $file->getInfo('name'));
            })->move('/tmp' . DS . 'stitp');
            $pathname = $info->getPathname();
        } else {
            return ['status' => false];
        }
        $cmdline = "llvm-slicing -m {$arg_m} -d {$arg_d} {$pathname} 2>&1";
        ob_start();
        echo time();
        echo "{$arg_m} {$arg_d}" . PHP_EOL;

        passthru($cmdline, $ret);
        $stdout = ob_get_clean();
        $result_json = Parser::AllVarParser($stdout, $arg_d);
        $this->result($result_json, $ret, 'success');

    }


}