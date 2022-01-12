<?php

use think\Db;

function get_system($name = null)
{

    if (!empty($name)) {
        $newres = db('system')->where('key', $name)->value('value');
    } else {
        $res = db('system')->select();
        foreach ($res as $r) {
            $newres[$r['key']] = $r['value'];
        }
    }
    return $newres;
}

function topString($level)
{
    $str = '';
    for ($i = 0; $i < $level; $i++) {
        $str .= '|----';
    }
    return $str;
}




function strToUtf8($str){
    $encode = mb_detect_encoding($str, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
    if($encode == 'UTF-8'){
        return $str;
    }else{
        return mb_convert_encoding($str, 'UTF-8', $encode);
    }
}
function match_chinese2($chars, $encoding = 'utf8')
{
//    return $chars;
    $pattern = ($encoding == 'utf8') ? '/[\x{4e00}-\x{9fa5}]|[\（\）\《\》\——\；\·\,\.\、\，\。\“\”\<\\\！]/u' : '/[\x80-\xFF]/';
    preg_match_all($pattern, $chars, $result);
    $temp = join('', $result[0]);
    return $temp;
}


