<?php


namespace app\api\controller;


use JonnyW\PhantomJs\Client;
use JonnyW\PhantomJs\DependencyInjection\ServiceContainer;
use QL\QueryList;
use think\Controller;

/**
 * 二代检测跳转版本 可抓取跳转后的tdk
 * Class Project2
 * @package app\api\controller
 */
class Project2 extends Baseapi
{
    public function run($id = null)
    {

        $dat = db('project')->where('id', $id)->find();
        $url = $dat['url'];

        $daa['error'] = 0;
        try {
            $da = $this->he($url);
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
            $daa['k'] = $exception;
            $daa['error'] = 2;
        }

//        dd($exception);
        $daa['pid'] = $dat['id'];
        $daa['create_time'] = date('Y-m-d H:i:s');
        $logid = db('run_log')->insertGetid($daa);
        db('project')->where('id', $dat['id'])->update(['log' => $logid]);
        return $this->success('ok', '', $daa);
    }

    //一键巡查
    public function runs($page = 1, $num = 20)
    {

        $info = db('project')->paginate($num, false, ['query' => request()->param()]);
        if (empty($info)) {
            die('ok');
        }
        foreach ($info as $dat) {
            $url = $dat['url'];

            $daa['error'] = 0;
            try {
                $da = $this->he($url);
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
                $daa['k'] = $exception;
                $daa['error'] = 2;
            }
            $daa['pid'] = $dat['id'];
            $daa['create_time'] = date('Y-m-d H:i:s');
            $logid = db('run_log')->insertGetid($daa);
            db('project')->where('id', $dat['id'])->update(['log' => $logid]);
            sleep(1);
        }
        $page = $page + 1;
        $this->redirect("/api/project/runs?page=" . $page . "&num=" . $num, '', '200');
    }


    public function he($url)
    {
        ini_set('max_execution_time', '0');
        ini_set("user_agent", "Mozilla/4.0 (compatible; MSIE 5.00; Windows 98)");
        ini_set('allow_url_fopen', 'On');
        foreach($_COOKIE as $key=>$value){
            setCookie($key,"",time()-60);
        }

        $url = "http://" . $url;
        $refer = "http://www.baidu.com";
        $url = trim($url);


        $data=$this->getbody($url);
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


        $temp[0] = str_replace("<title", '', $temp[0]);
        $temp[0] = str_replace("<Title", '', $temp[0]);
        $temp[0] = str_replace("</title", '', $temp[0]);
        $temp[0] = str_replace("</Title", '', $temp[0]);

        $daa['error'] = 0;

        $daa['t'] = match_chinese2(str_replace("", '', $temp[0]));
        if ($daa['t'] == '') {
            $daa['t'] = match_chinese2(str_replace("", '', html_entity_decode(@$temp[0])));
        }

        if (!preg_match("/name=\"keywords.*?\n?.*?>/", $str, $temp)) {
            preg_match("/name=\"Keywords.*?\n?.*?>/", $str, $temp);
        }

        $daa['d'] = match_chinese2(@$temp[0]);
        if ($daa['d'] == '') {
            $daa['d'] = match_chinese2(str_replace("", '', html_entity_decode(@$temp[0])));
        }

        if (!preg_match("/name=\"description.*?\n?.*?\>/", $str, $temp)) {
            preg_match("/name=\"Description.*?\n?.*?\>/", $str, $temp);
        }
        $daa['k'] = match_chinese2(@$temp[0]);
        if ($daa['k'] == '') {
            $daa['k'] = match_chinese2(str_replace("", '', html_entity_decode(@$temp[0])));
        }
        $kill = $this->system['kill'];
        $kill = explode('|', $kill);
        foreach ($kill as $k) {
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



    public function getbody($url){
        $location = '/usr/local/phantomjs/';//自定义模块所在文件夹
        $serviceContainer = ServiceContainer::getInstance();
        $procedureLoader = $serviceContainer->get('procedure_loader_factory')
            ->createProcedureLoader($location);//详细参见本文页尾

        /*正常实例*/
        $client = Client::getInstance();//实例


        /*渲染与请求方式*/
        $link = $url;//请求的url
        $client->isLazy(); // 是否让客户端等待所有资源加载完毕,开启此项务必开始setTimeout,避免轮询页面不断等待.
        $request = $client->getMessageFactory()->createRequest();
        $response = $client->getMessageFactory()->createResponse();
        $request->setUrl($link);
        $request->setMethod('GET');//可GET|POST|OPTIONS|HEAD|DELETE|PATCH|PUT
        $request->setTimeout(3000);//超过指定时间则中断渲染
        $request->setDelay(3);//设置延迟5秒
        $request->setRequestData(array('param1' => 'Param 1', 'param2' => 'Param 2'));//POST时发送的数据
        $request->addHeader('referrer', 'http://www.baidu.com');//自定义头信息
        $request->addHeader('Referer', 'http://www.baidu.com');//自定义头信息
        $client->send($request, $response);//发送请求

        $data = $response->getContent();//返回正文
        return $data;
    }
}