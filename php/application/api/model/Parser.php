<?php
/**
 * Created by PhpStorm.
 * User: Richard
 * Date: 2016/10/29
 * Time: 20:00
 */

namespace app\api\model;


class Parser
{


    public static function AllVarParser($stdout)
    {

        $file_lines = explode("\n", $stdout);

        //select lines that contains slicing results, i.e. contains `{"aaa:[1,2,3]"}`.
        $arr_slices = array_filter($file_lines, function ($line) { return 0 != preg_match('/\{.*\}/', $line); });

        $json_slices = [];
        foreach ($arr_slices as $key => $line) {
            //eg. fpScore@printTop    {"guess.c: [63,64,69,380,401]"}
            $varname = trim(strstr($line, '{', true)); // "fpScore@printTop"
            $slice = trim(strstr($line, '{')); // {"guess.c: [63,64,69,380,401]"}
            $slice = str_replace([':', ']"}'], ['":', ']}'], $slice); // {"guess.c": [63,64,69,380,401]}
            $slice = json_decode($slice, true);
            $json_slices[$varname] = $slice;
        }
        return $json_slices;

    }


}