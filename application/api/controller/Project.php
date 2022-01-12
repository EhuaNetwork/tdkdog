<?php


namespace app\api\controller;


use JonnyW\PhantomJs\Client;
use JonnyW\PhantomJs\DependencyInjection\ServiceContainer;
use QL\QueryList;
use think\Controller;
use think\exception\ErrorException;
use WxRot\WxRot;

/**
 * 一代简约版本 仅抓取tdk
 * Class Project
 * @package app\api\controller
 */
class Project extends Baseapi
{
    public function run($id = null)
    {

        $dat = db('article')->where('id', $id)->find();
        $url = $dat['url'];
        $daa['error'] = 0;
        if (gethostbyname($url)!=$url) {
//            try {
                $uid = $dat['uid'];
                $da = $this->he($dat['name'], $url, $uid);
                $daa['t'] = $da['t'];
                $daa['d'] = $da['d'];
                $daa['k'] = $da['k'];
                $daa['error'] = $da['error'];
                if (empty($daa['t']) || empty($daa['d']) || empty($daa['k'])) {
                    $daa['error'] = 1;
                }
//            } catch (\Exception $exception) {
//                $daa['t'] = "<span style='color:red'>数据异常</span>";
//                $daa['d'] = "<span style='color:red'>数据异常</span>";
//                $daa['k'] = '狗子无法访问该网站';
//                $daa['error'] = 2;
//            }

        } else {
            $daa['t'] = "<span style='color:red'>域名到期</span>";
            $daa['d'] = "<span style='color:red'>域名到期</span>";
            $daa['k'] = '域名到期';
            $daa['error'] = 2;

        }


        if ($daa['error'] == 3) {
            $this->push($dat['name'], $url);
        }
//        dd($exception);
        $daa['pid'] = $dat['id'];
        $daa['create_time'] = date('Y-m-d H:i:s');
        $logid = db('run_log')->insertGetid($daa);
        db('article')->where('id', $dat['id'])->update(['log' => $logid]);
        return $this->success('ok', '', $daa);
    }

    public $ch;

    private function _GetContent($url)
    {
        $this->ch = curl_init();
        $this->ip = '220.181.108.91';  // 百度蜘蛛
        $this->timeout = 15;
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 0);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        //伪造百度蜘蛛IP
        curl_setopt($this->ch, CURLOPT_HTTPHEADER, array('X-FORWARDED-FOR:' . $this->ip . '', 'CLIENT-IP:' . $this->ip . ''));
        //伪造百度蜘蛛头部
        curl_setopt($this->ch, CURLOPT_USERAGENT, "Mozilla/5.0 (compatible; Baiduspider/2.0; +http://www.baidu.com/search/spider.html)");
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_HEADER, 0);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, $this->timeout);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1); //是否抓取跳转后的页面

        $content = curl_exec($this->ch);
        if ($content === false) {//输出错误信息
            $no = curl_errno($this->ch);
            switch (trim($no)) {
                case 28 :
                    $this->error = '访问目标地址超时';
                    break;
                default :
                    $this->error = curl_error($this->ch);
                    break;
            }
            echo $this->error;
        } else {
            $this->succ = true;
            return $content;
        }
    }

    //一键巡查
    public function runs($page = 1, $num = 20)
    {

        $info = db('article')->paginate($num, false, ['query' => request()->param()]);
        if (empty($info)) {
            die('ok');
        }
        foreach ($info as $dat) {
            $url = $dat['url'];

            $daa['error'] = 0;
            if (gethostbyname($url)!=$url) {

                try {
                    $uid = $dat['uid'];

                    $da = $this->he($dat['name'], $url, $uid);

                    $daa['t'] = $da['t'];
                    $daa['d'] = $da['d'];
                    $daa['k'] = $da['k'];
                    $daa['error'] = $da['error'];

                    if (empty($daa['t']) || empty($daa['d']) || empty($daa['k'])) {
                        $daa['error'] = 1;
                    }
                } catch (\Exception $exception) {
                    $daa['t'] = "<span style='color:red'>数据异常</span>";
                    $daa['d'] = "<span style='color:red'>数据异常</span>";
                    $daa['k'] = '狗子无法访问该网站';
                    $daa['error'] = 2;
                }

            } else {
                $daa['t'] = "<span style='color:red'>域名到期</span>";
                $daa['d'] = "<span style='color:red'>域名到期</span>";
                $daa['k'] = '域名到期';
                $daa['error'] = 2;

            }
            if ($daa['error'] == 3) {
//                $this->push($dat['name'],$url);
            }
            $daa['pid'] = $dat['id'];
            $daa['create_time'] = date('Y-m-d H:i:s');
            $logid = db('run_log')->insertGetid($daa);
            db('article')->where('id', $dat['id'])->update(['log' => $logid]);
            sleep(1);
        }
        $page = $page + 1;
        $this->redirect("/api/project/runs?page=" . $page . "&num=" . $num, '', '200');
    }


    public function he($name, $url, $uid = 1)
    {
        ini_set('max_execution_time', '0');
        ini_set("user_agent", "Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)");
        ini_set('allow_url_fopen', 'On');
        foreach ($_COOKIE as $key => $value) {
            setCookie($key, "", time() - 60);
        }

        $url = "http://" . $url;
        $refer = "http://www.baidu.com";
        $url = trim($url);

        $data = $this->_GetContent($url);

        //显示获得的数据
//$data=file_get_contents($url);
        $str = $data;
        $str = strToUtf8($str);
        //标题
//        $data = QueryList::html($data);
//        $daa['t'] = $data->find('title')->html();
        if (!preg_match("/\<title\>.*?\<\/title\>/", $str, $temp)) {
            preg_match("/\<Title\>.*?\<\/Title\>/", $str, $temp);
        }
        if (empty($temp[0])) $temp[0] = '';

        $temp[0] = str_replace("<title", '', $temp[0]);
        $temp[0] = str_replace("<Title", '', $temp[0]);
        $temp[0] = str_replace("</title", '', $temp[0]);
        $temp[0] = str_replace("</Title", '', $temp[0]);

        $daa['error'] = 0;

//        $daa['t'] = match_chinese2(str_replace("", '', $temp[0]));
        $daa['t'] = trim(str_replace("", '', $temp[0]), '>');

        if ($daa['t'] == '') {
            $daa['t'] = match_chinese2(str_replace("", '', html_entity_decode(@$temp[0])));
        }

        if (!preg_match("/name=\"keywords.*?\n?.*?>/", $str, $temp)) {
            preg_match("/name=\"Keywords.*?\n?.*?>/", $str, $temp);
        }
//        $daa['d'] = match_chinese2(@$temp[0]);
        preg_match("/content=\".*?\n?.*?\"/", @$temp[0], $temp);
        $daa['d'] = trim(str_replace('content="', '', trim(@$temp[0], '>')), '"');
        if ($daa['d'] == '') {
            $daa['d'] = match_chinese2(str_replace("", '', html_entity_decode(@$temp[0])));
        }

        if (!preg_match("/name=\"description.*?\n?.*?\>/", $str, $temp)) {
            preg_match("/name=\"Description.*?\n?.*?\>/", $str, $temp);
        }
//        $daa['k'] = match_chinese2(@$temp[0]);

        preg_match("/content=\".*?\n?.*?\"/", @$temp[0], $temp);

        $daa['k'] = trim(str_replace('content="', '', trim(@$temp[0], '>')), '"');

        if ($daa['k'] == '') {
            $daa['k'] = match_chinese2(str_replace("", '', html_entity_decode(@$temp[0])));
        }
        $kill = db('admin')->where('id', 1)->value('kill');
        $kill = explode('|', $kill);
        $kill = array_filter($kill);
        foreach ($kill as $k) {

            $daa['t'] = html_entity_decode($daa['t']);
            $daa['d'] = html_entity_decode($daa['d']);
            $daa['k'] = html_entity_decode($daa['k']);
            if (strpos($daa['t'], $k)) {
                $daa['error'] = 3;
                $daa['t'] = str_replace($k, "<span style='color: red'>" . $k . '</span>', $daa['t']);
            };
            if (strpos($daa['d'], $k)) {
                $daa['error'] = 3;
                $daa['d'] = str_replace($k, "<span style='color: red'>" . $k . '</span>', $daa['d']);
            };
            if (strpos($daa['k'], $k)) {
                $daa['error'] = 3;
                $daa['k'] = str_replace($k, "<span style='color: red'>" . $k . '</span>', $daa['k']);
            };
        }

        return $daa;
    }

    function push($name, $url)
    {
        return;
        $ROT = new WxRot();

        $wxid = 'wxid_dx8senvu6jzm22';

//        $res = $ROT->GetGroupList($wxid,true);
        $group_wxid = "17733946668@chatroom";
        $member_wxid = false;
        $msg = "【{$name}】挂🐎啦！！！
" . $url;
        $res = $ROT->SendGroupMsgAndAt($wxid, $group_wxid, $member_wxid, $member_name = null, $msg);
    }

    function array_iconv($data, $output = 'utf-8')
    {
        $encode_arr = array('UTF-8', 'ASCII', 'GBK', 'GB2312', 'BIG5', 'JIS', 'eucjp-win', 'sjis-win', 'EUC-JP');
        $encoded = mb_detect_encoding($data, $encode_arr);
        if (!is_array($data)) {
            return mb_convert_encoding($data, $output, $encoded);
        } else {
            foreach ($data as $key => $val) {
                $key = array_iconv($key, $output);
                if (is_array($val)) {
                    $data[$key] = array_iconv($val, $output);
                } else {
                    $data[$key] = mb_convert_encoding($data, $output, $encoded);
                }
            }
            return $data;
        }
    }
}