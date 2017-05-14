<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2017/3/18
 * Time: 15:08
 */

namespace app\api\model;

class Source
{
    protected $tmppath = "/tmp/stitp";
    protected $path;
    protected $hash;
    private $stdout;
    private $ret;
    private $direction;
    private $slice_data;


    public function __construct(Array $arg)
    {
        $this->code = $arg['code'];
        $this->direction = $arg['direction'];


        $this->hash = substr(md5($this->code), 0, 8);
        $this->filename = $this->hash . '.c';
        $this->path = "{$this->tmppath}/{$this->hash}";

        if ( !is_dir($this->path)) {
            mkdir($this->path, 0777, true);
        }
        chdir($this->path);
        $fp = fopen($this->filename, 'w+b');
        fwrite($fp, $this->code);
        fclose($fp);
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
        $cmdline = "llvm-slicing -m Symbolic -d {$this->direction} {$this->filename} 2>&1";

        chdir($this->path);
        ob_start();
        passthru($cmdline, $this->ret);
        $this->stdout = ob_get_clean();//Calling llvm-slicing done, start parse stdout below
        $this->slice_data = Parser::AllVarParser($this->stdout);
        return $this;
    }


    public function call_graph()
    {
        chdir($this->path);
        $cmdline = "llvm-slicing -g Cg {$this->filename}";
        ob_start();
        passthru($cmdline, $this->ret);//Generates file "basename.dot"
        $this->stdout = ob_get_clean();
        $dot_file = $this->hash . '_CG.dot';
        ob_start();
        passthru("dot -Tsvg {$dot_file}", $this->ret);
        $this->stdout = ob_get_clean();

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

    /**
     * @return bool|string
     */
    public function getHash()
    {
        return $this->hash;
    }

}