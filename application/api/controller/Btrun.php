<?php


namespace app\api\controller;

use DtApp\Bt\BtException;
use DtApp\Bt\Firewall;
use DtApp\Bt\Site;
use DtApp\Bt\Soft;

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
        // +----------------------------------------------------------------------
        // | 宝塔PHP扩展包
        // +----------------------------------------------------------------------
        // | 版权所有 2017~2020 [ https://www.dtapp.net ]
        // +----------------------------------------------------------------------
        // | 官方网站: https://gitee.com/liguangchun/bt
        // +----------------------------------------------------------------------
        // | 开源协议 ( https://mit-license.org )
        // +----------------------------------------------------------------------
        // | gitee 仓库地址 ：https://gitee.com/liguangchun/bt
        // | github 仓库地址 ：https://github.com/GC0202/bt
        // | Packagist 地址 ：https://packagist.org/packages/liguangchun/bt
        // +----------------------------------------------------------------------
        $page = 1;
        $conf = $this->getapi(219);
        $config = [
            'key' => $conf['key'],
            'panel' => "http://" . $conf['ip'] . ':' . $conf['port'] . "/",
        ];

        try {
            $soft = new Site($config);
            $list = $soft->getList($page, 300);
//            dd($list);
            foreach ($list['data'] as $dat) {
                $man = $soft->getmain($dat['id']);
                echo "<pre>";
                $db_data = [
                    'title' => $dat['ps'],
                    'server' => $conf['ip'],
                    'url' => $man['data'][0]['name'],
                    'style' => 2,
                ];
                try {
                    db('project')->insert($db_data);
                } catch (\Exception $e) {
                    echo $e->getMessage();
                    echo "<br>";
                }
            }

        } catch (\Exception $e) {
            var_dump($e->getMessage());
        }


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
                'port' => '8888',
                'key' => 'jcAI5fbJyOhvzOF2jMxS0I1EfLNX0R37',
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