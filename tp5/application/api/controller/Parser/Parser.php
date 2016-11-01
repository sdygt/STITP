<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2016/10/29
 * Time: 20:00
 */

namespace app\api\controller\Parser;

use think\Controller;

class Parser extends Controller
{
    public static function AllVarParser($stdout, $arg_d)
    {
        switch ($arg_d) {
            case 'Fwd':
                //no break
            case 'Bwd':
                return self::AllVarParser_1d($stdout, $arg_d);
                break;
            case 'Both':
                return self::AllVarParser_2d($stdout);
                break;
        }

    }

    private static function AllVarParser_1d($stdout, $arg_d)
    {
        preg_match_all("/(?<=------------------------------)(.*)(?=Its some statistic Info.:)/ms", $stdout, $table);
        $table = $table[0][0];
        $arrTable = explode("\n", $table);
        $arrTable = array_slice($arrTable, 1);//ltrim empty line
        while (array_pop($arrTable) === '') {
        };
        array_pop($arrTable);//rtrim empty line
        $arrTable = self::ParseTable($arrTable);
        return [$arg_d => $arrTable];

    }

    private static function ParseTable($arrTable)
    {
        $ret = [];
        foreach ($arrTable as $line) {
            preg_match('/\w?(.*)(?=\w*{)/', $line, $varname);
            $varname = trim($varname[0]);
            preg_match('/(?<={)(.*)(?=})/', $line, $arrRefFiles);
            //    $arrRefFile=explode('","',$arrRefFile[0]);
            $arrRefFiles = preg_split('/(?<="),(?=")/', $arrRefFiles[0]);
            $ref = [];
            foreach ($arrRefFiles as $file) {
                $file = str_replace('"', '', $file);
                preg_match('/(.*)(?=:)/', $file, $filename);
                preg_match('/(?<=:)(.*)/', $file, $linenum);
                //        echo $filename[0].'##'.$linenum[0];
                $ref[$filename[0]] = json_decode(trim($linenum[0]), true);
            }

            $ret[$varname] = $ref;
        }

        return $ret;
    }

    private static function AllVarParser_2d($stdout)
    {
        preg_match_all("/(?<=------------------------------)(.*)(?=Forward Static SliceTable:)/ms", $stdout,
            $table_bwd);
        $table_bwd = $table_bwd[0][0];
        $arrTable_bwd = explode("\n", $table_bwd);
        $arrTable_bwd = array_slice($arrTable_bwd, 1);//ltrim empty line
        while (array_pop($arrTable_bwd) === '') {
        };
        array_pop($arrTable_bwd);//rtrim empty line


        $stdout = preg_replace("/^(.*)(?=Forward Static SliceTable:)/ms", '', $stdout);
        //stripout first table

        preg_match_all("/(?<=------------------------------)(.*)(?=Its some statistic Info.:)/ms", $stdout, $table_fwd);


        $table_fwd = $table_fwd[0][0];

        $arrTable_fwd = explode("\n", $table_fwd);
        $arrTable_fwd = array_slice($arrTable_fwd, 1);//ltrim empty line
        while (array_pop($arrTable_fwd) === '') {
        };
        array_pop($arrTable_fwd);//rtrim empty line

        $arrTable_bwd = self::ParseTable($arrTable_bwd);
        $arrTable_fwd = self::ParseTable($arrTable_fwd);

        return ["Bwd" => $arrTable_bwd, "Fwd" => $arrTable_fwd];

    }

    public static function SingleVarParser($stdout, $arg_d)
    {
        switch ($arg_d) {
            case 'Fwd':
                //no break
            case 'Bwd':
                return self::SingleVarParser_1d($stdout);
                break;
            case 'Both':
                return self::SingleVarParser_2d($stdout);
                break;
        }
    }

    private static function SingleVarParser_1d($stdout)
    {
        preg_match('/(?<=]:)(.*)(?=Its some statistic Info.:)/sm', $stdout, $ir);
        $ir = trim($ir[0]);
        return $ir;
    }

    private static function SingleVarParser_2d($stdout)
    {
        preg_match('/(Backward)(.*)(?=Its some statistic Info.:)/sm', $stdout, $ir);
        $ir = trim($ir[0]);
        return $ir;
    }


}