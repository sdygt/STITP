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
    public function check_syntax()
    {
        $file = request()->file('file-0');
        if ($file) {
            $hashid = substr($file->hash('md5'), 0, 8);
            $path = "/tmp/stitp/{$hashid}";
            $info = $file->rule(function ($file) {
                return substr($file->hash('md5'), 0, 8) . '_' . preg_replace('/\h+/', '_',
                    $file->getInfo('name'));
            })->move($path);
            $pathname = $info->getPathname();
            $filename = basename($pathname);
        } else {
            $this->result(null, 1, 'Upload Error');
        }
        chdir($path);
        ob_start();
        passthru('clang -fsyntax-only ' . $filename . ' 2>&1', $ret);
        $stdout = ob_get_clean();
        if ($ret === 0) {
            $this->result(['filename' => $filename, 'hash' => $hashid], 0, 'Syntax check successful');
        } else {
            $this->result(['filename' => $filename, 'hash' => $hashid], 0, $stdout);
        }
    }

    public function slice_dispatcher()
    {
        $arg_m = input('post.arg_m');
        $arg_d = input('post.arg_d');
        $arg_c = input('post.arg_c');
        if ( !isset($arg_d) || !isset($arg_m)) {
            $this->result(null, 2, 'Missing Argument');
        }

        $file = request()->file('file-0');
        if ($file) {
            $hashid = substr($file->hash('md5'), 0, 8);
            $path = "/tmp/stitp/{$hashid}";
            $info = $file->rule(function ($file) {
                return substr($file->hash('md5'), 0, 8) . '_' . preg_replace('/\h+/', '_',
                    $file->getInfo('name'));
            })->move($path);
            $pathname = $info->getPathname();
            $filename = basename($pathname);
        } else {
            $this->result(null, 1, 'Upload Error');
        }

        chdir($path);
        if (isset($arg_c)) {
            $cmdline = "llvm-slicing -m {$arg_m} -d {$arg_d} -c {$arg_c} {$filename} 2>&1";

        } else {
            $cmdline = "llvm-slicing -m {$arg_m} -d {$arg_d} {$filename} 2>&1";

        }
        ob_start();
        passthru($cmdline, $ret);
        $stdout = ob_get_clean();

        if (isset($arg_c)) {
            $result = ['ir' => Parser::SingleVarParser($stdout, $arg_d)];
        } else {
            $result = ['table' => Parser::AllVarParser($stdout, $arg_d)];
        }
        $result += ['filename' => basename($info->getPathname()), 'hash' => $hashid];
        $this->result($result, $ret, 'success');


    }

}