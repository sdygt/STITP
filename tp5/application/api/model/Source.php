<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2017/3/18
 * Time: 15:08
 */

namespace app\api\model;

use app\api\controller\Exception\UploadException;
use think\File;

class Source
{
    protected $pathname;
    protected $path;
    protected $filename;
    protected $hash;
    private $file;
    private $info;
    private $stdout;
    private $ret;
    private $arg = ['m' => null, 'd' => null, 'c' => null];
    private $slice_data;


    public function __construct(File $file)
    {
        $this->file = $file;

        if ( !$file) {
            throw new UploadException('Upload Error');
        }

        $this->hash = substr($this->file->hash(), 0, 8);
        $this->path = "/tmp/stitp/{$this->hash}";

        $this->info = $this->file->rule(function () { return $this->hash; })->move($this->path);

        if ( !$this->info) {
            throw new UploadException('Error when moving uploaded file');
        }
        $this->pathname = $this->info->getPathname();
        $this->filename = pathinfo($this->pathname, PATHINFO_BASENAME);

    }

    public function checkSyntax()
    {
        chdir($this->path);
        ob_start();
        passthru("clang -fsyntax-only $this->filename 2>&1", $this->ret);
        $this->stdout = ob_get_clean();
        return $this;
    }

    public function slice()
    {
        if (isset($this->arg['c'])) {
            $cmdline = "llvm-slicing -m {$this->arg['m']} -d {$this->arg['d']} -c {$this->arg['c']} {$this->filename} 2>&1";
        } else {
            $cmdline = "llvm-slicing -m {$this->arg['m']} -d {$this->arg['d']} {$this->filename} 2>&1";
        }
        echo($cmdline);
        chdir($this->path);
        ob_start();
        passthru($cmdline, $this->ret);
        $this->stdout = ob_get_clean();//Calling llvm-slicing done, start parse stdout below

        if (isset($this->arg['c'])) {
            $this->slice_data = Parser::SingleVarParser($this->stdout, $this->arg['d']);
        } else {
            $this->slice_data = Parser::AllVarParser($this->stdout, $this->arg['d']);
        }
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStdout()
    {
        return $this->stdout;
    }

    /**
     * @return mixed
     */
    public function getRet()
    {
        return $this->ret;
    }

    /**
     * @param array $slicingArgument
     * @return Source
     */
    public function setArg(array $slicingArgument): Source
    {

        $this->arg = $slicingArgument;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSliceData()
    {
        return $this->slice_data;
    }

}