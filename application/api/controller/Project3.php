<?php


namespace app\api\controller;


use Facebook\WebDriver\Cookie;
use Facebook\WebDriver\Exception\JavascriptErrorException;
use Facebook\WebDriver\Exception\NoSuchElementException;
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Chrome\ChromeOptions;
use Facebook\WebDriver\Remote\WebDriverCapabilityType;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverKeys;
use think\Controller;
use think\Exception;

/**
 * 三代 selenum版本
 * Class Project3
 * @package app\api\controller
 */
class Project3 extends Controller
{
    public function _initialize()
    {

    }

    public function init()
    {
        header("Content-Type: text/html; charset=UTF-8");
// start Firefox with 5 second timeout
        $waitSeconds = 5;  //需等待加载的时间，一般加载时间在0-15秒，如果超过15秒，报错。
        $host = 'http://localhost:9515'; // this is the default
//这里使用的是chrome浏览器进行测试，需到http://www.seleniumhq.org/download/上下载对应的浏览器测试插件
//我这里下载的是win32 Google Chrome Driver 2.25版：https://chromedriver.storage.googleapis.com/index.html?path=2.25/

        $capabilities = DesiredCapabilities::chrome();
//header头
        $useragent = 'Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/71.0.3578.98 Safari/53';
        $options = new ChromeOptions();
        //设置ua
        $options->addArguments(["user-agent={$useragent}"]);
        //无痕模式
        $options->addArguments(["incognito"]);
        //linux 兼容
        $options->addArguments(["--no-sandbox"]);
        $options->addArguments(["--disable-gpu"]);
//        $options->addArguments(["--headless"]);
        //设置窗口大小
        $options->addArguments(['window-size=1024,768']);
        // 禁用SSL证书
        $capabilities->setCapability('acceptSslCerts', false);
        //无头
        $capabilities->setCapability('ChromeOptions', ['args' => ['-headless']]);


        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        //浏览器设置不加载图片
//        $value = ['profile.managed_default_content_settings.images' => 2];
//        $options->setExperimentalOption('prefs', $value);
//        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);

        //防检测
        $options->setExperimentalOption('excludeSwitches', ['enable-automation']);
        $options->setExperimentalOption('useAutomationExtension', false);
        $capabilities->setCapability(ChromeOptions::CAPABILITY, $options);;

        //隐性设置15秒
        $driver = RemoteWebDriver::create($host, $capabilities, 2000);
//        $driver->manage()->timeouts()->implicitlyWait(2);

        return $driver;
    }

    public function DoerrorCode($driver)
    {
//执行js脚本
//        try {
//            $driver->executeScript("document.getElementById('verify-bar-close').click()");
//            $driver->executeScript("document.getElementById('verify-bar-close').click()");
//            $driver->executeScript("document.getElementById('verify-bar-close').click()");
//        } catch (NoSuchElementException $exception) {
//
//        } catch (JavascriptErrorException $exception) {
//
//        }
    }

    public function Task2()
    {

        $daa['key'] = '破碎锤';

        $driver = $this->init();

        $key = $daa['key'];
        $driver->get("https://www.baidu.com/s?ie=UTF-8&wd=$key");
        $this->setcookie($driver);
        $cookies = $driver->manage()->getCookies();


        for ($ii = 0; $ii < 6; $ii++) {
            $driver->getKeyboard()->pressKey(WebDriverKeys::PAGE_DOWN);
            sleep(1);
        }
        sleep(1);

        $this->DoerrorCode($driver);

        // Execute javascript:
// Or to execute the javascript as non-blocking, ie. asynchronously:


        $lis = $driver->findElements(WebDriverBy::className('c-container'));

        for ($i = 1; $i < count($lis) ; $i++) {
            try {
                $data[$i]['title'] = $driver->findElement(WebDriverBy::xpath("/html/body/div[1]/div[4]/div[1]/div[3]/div[$i]/h3"))->getText();
                $data[$i]['url'] = $driver->findElement(WebDriverBy::xpath("/html/body/div/div[4]/div[1]/div[3]/div[$i]/h3/a"))->getAttribute('href');
            }catch (\Exception $exception){

            }

        }


//        $driver->quit();
dd($data);

    }


    public function getVinfo($url, $k)
    {

        try {
            //视频链接
            $data['share_url'] = $url;
            $md5 = md5($url);
            if ($d = db('dou_video_all_fillder')->where('md5', '=', $md5)->find()) {
                return json(['code' => 200, 'msg' => 'ok', 'data' => $d]);
            }


            $driver = $this->init();
            $driver->get($url);


            //标题
            $data['title'] = $driver->findElement(WebDriverBy::xpath('//*[@id="root"]/div/div[2]/div[1]/div[1]/div[1]/div[2]/h1'))->getText();
            //发布者主页
            $data['open_id'] = $driver->findElement(WebDriverBy::xpath('//*[@id="root"]/div/div[2]/div[1]/div[2]/div/div[1]/div[2]/a'))->getAttribute('href');

            //发布者昵称
            $data['nickname'] = $driver->findElement(WebDriverBy::xpath('//*[@id="root"]/div/div[2]/div[1]/div[2]/div/div[1]/div[2]/a/div/span/span/span/span/span'))->getText();

            //视频缩略图
            $data['cover'] = '';
            $data['create_time'] = date('Y-m-d H:i:s', time());
            $data['key'] = $k;
            $data['md5'] = $md5;
            return json(['code' => 200, 'msg' => 'ok', 'data' => $data]);

        } catch (NoSuchElementException $exception) {
            logs('数据抓取异常', $data);
            return json(['code' => 500, 'msg' => '数据抓取异常', 'data' => null]);
        }
    }


//切换至最后一个window
    function switchToEndWindow($driver)
    {

        $arr = $driver->getWindowHandles();
        foreach ($arr as $k => $v) {
            if ($k == (count($arr) - 1)) {
                $driver->switchTo()->window($v);
            }
        }
    }

    public function setcookie($driver)
    {
        $driver->manage()->deleteAllCookies();//清空cookie
        //设置cookie
        $driver->manage()->addCookie(array(
            'name' => 'MONITOR_WEB_ID',
            'value' => '1c3c3b65-af0d-491e-a00c-d6412b9bf672',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'n_mh',
            'value' => 'AvuOalnEdDADT4KEAQFSr3XttUiPiiWLQnYH0PaJA90',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'odin_tt',
            'value' => '4ffa031d38b7b0f70105458e0ac0ce194b38198b064eabf8412128728c716d24d63c60e7f1553eb695612a03b9d9d285dc93babdb2fbf785ef46dcd3bb731612',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'passport_auth_status',
            'value' => '57c6de3db073730df89963c157fc34af%2C',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'passport_auth_status_ss',
            'value' => '57c6de3db073730df89963c157fc34af%2C',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'passport_csrf_token',
            'value' => '8471640c7a23c52ef5c861726da884d4',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'passport_csrf_token_default',
            'value' => '8471640c7a23c52ef5c861726da884d4',
        ));
        $driver->manage()->addCookie(array(
            'name' => 's_v_web_id',
            'value' => 'verify_ks5nf0gs_AKWJDRVb_cYkg_4oky_87bv_6wGnCsAwukxM',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'sessionid',
            'value' => '6afb3e8cd5724ca8bb98eded9d48889a',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'sessionid_ss',
            'value' => '6afb3e8cd5724ca8bb98eded9d48889a',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'sid_guard',
            'value' => '6afb3e8cd5724ca8bb98eded9d48889a%7C1628574869%7C5183998%7CSat%2C+09-Oct-2021+05%3A54%3A27+GMT',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'sid_tt',
            'value' => '6afb3e8cd5724ca8bb98eded9d48889a',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'sid_ucp_v1',
            'value' => '1.0.0-KDNhMzM5NTY4MmM1MmU5Y2VjNGM4ZGY5OWU2YzI0YzlhMGZjMjY2NmUKFQjVo6TnmgMQlanIiAYY7zE4BkD0BxoCbGYiIDZhZmIzZThjZDU3MjRjYThiYjk4ZWRlZDlkNDg4ODlh',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'ssid_ucp_v1',
            'value' => '1.0.0-KDNhMzM5NTY4MmM1MmU5Y2VjNGM4ZGY5OWU2YzI0YzlhMGZjMjY2NmUKFQjVo6TnmgMQlanIiAYY7zE4BkD0BxoCbGYiIDZhZmIzZThjZDU3MjRjYThiYjk4ZWRlZDlkNDg4ODlh',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'sso_uid_tt',
            'value' => '12527d1906a23028402aa2eaf52af0e8',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'sso_uid_tt_ss',
            'value' => '12527d1906a23028402aa2eaf52af0e8',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'toutiao_sso_user',
            'value' => '2e694db809aa6795935dc05b7b5f3ffb',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'toutiao_sso_user_ss',
            'value' => '2e694db809aa6795935dc05b7b5f3ffb',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'ttwid',
            'value' => '1%7Czs6NlzeUlWAAPn0iCxFil9Q23ow3W6uHbyCPbnXsVh8%7C1628574846%7Cacdae0089e488a00c6036b5b3673473821bf9e276a0d8d11016304f9c34a3492',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'uid_tt',
            'value' => '346727e8e746b23276cbe1bc628b4b85',
        ));
        $driver->manage()->addCookie(array(
            'name' => 'uid_tt_ss',
            'value' => '346727e8e746b23276cbe1bc628b4b85',
        ));


    }

    //切换至第一个window
    function switchToHomeWindow($driver)
    {

        $arr = $driver->getWindowHandles();
        foreach ($arr as $k => $v) {
            if ($k == 0) {
                var_dump($v);
                $driver->switchTo()->window($v);
            }
        }
    }

    public $cfg;
    public $system;

}