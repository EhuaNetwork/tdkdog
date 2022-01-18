<?php


namespace app\api\controller;

use Ehua\Bt\BtException;
use Ehua\Bt\Firewall;
use Ehua\Bt\Site;
use Ehua\Bt\Soft;

/**
 * 宝塔站点导入
 * Class Btrun
 * @package app\api\controller
 */
class Btrun
{

    public function run($bool = false)
    {
        if ($bool == false) {
            die;
        }
        $page = 1;
        $conf = $this->getapi(219);
        $config = [
            'key' => $conf['key'],
            'panel' => "http://" . $conf['ip'] . ':' . $conf['port'] . "/",
        ];

//        try {
            $soft = new Site($config);
            $list = $soft->getList($page, 300);
            foreach ($list['data'] as $dat) {
                $man = $soft->getmain($dat['id']);
                echo "<pre>";
                $db_data = [
                    'name' => $dat['ps'],
                    'server' => $conf['ip'],
                    'url' => $man['data'][0]['name'],
                    'type' => 4,
                ];
                try {
//                    db('article')->insert($db_data);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    echo "<br>";
                }
              $url=  $db_data['url'];
              $name=  $db_data['name'];
                echo <<<eof
<a href="//$url" target="_blank">$name</a><br>
eof;


            }


//        } catch (\Exception $e) {
//            var_dump($e->getMessage());
//        }


    }
    public function getapi($id)
    {
        $arr = [
            219 => [
                'ip' => '123.57.187.219',
                'port' => '999',
                'key' => '8lFwAbTagQoixy03fp1qRKHGkBL0QwuQ',
            ],
            71 => [
                'ip' => '129.226.125.71',
                'port' => '999',
                'key' => 'HERDlXiPiT3CtZUhF8bFW3vKEnVqVYm1',
            ],
            42 => [
                'ip' => '101.32.206.42',
                'port' => '999',
                'key' => 'fwCFv47N0rIThPIIsBOMkr0eUpQv9Ril',
            ],
            209 => [
                'ip' => '119.28.8.209',
                'port' => '9999',
                'key' => 'argtUVdjSoqan5ofdKSYLtfbRK8bNmJf',
            ],
            181 => [
                'ip' => '47.244.254.181',
                'port' => '9999',
                'key' => 'bLVLtp4GEqGA1PmBZoX34kGKQ1lllTGN',
            ],
            107 => [
                'ip' => '120.53.23.107',
                'port' => '999',
                'key' => 'eI6DIlk6ta8zeb4L2SQYMq0ekSZc7TAr',
            ],
            88 => [
                'ip' => '47.92.227.88',
                'port' => '8888',
                'key' => '0AAEhh03uU2qbCPRNmaATOrGuegskoAi',
            ],
            251 => [
                'ip' => '115.28.138.251',
                'port' => '9999',
                'key' => 'DWeuz23loftQQw4XaVAaodjCkuEc185G',
            ],
            123 => [
                'ip' => '47.90.102.123',
                'port' => '8888',
                'key' => 'XE7PJg55bmTshugbXgEjhXmOGTPcjyY4',
            ],
        ];

        return $arr[$id];
    }

}