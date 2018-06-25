<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 16:03
 */

namespace OverNick\Auth\Server;

use OverNick\Auth\Kernel\Action;
use OverNick\Auth\Kernel\Abstracts\BaseAppAbstract;

/**
 * 服务端
 *
 * Class ServerApp
 *
 * @property \OverNick\Auth\Server\Base\Client $base
 *
 * @package OverNick\Auth
 */
class App extends BaseAppAbstract
{
    protected $providers = [
        Base\ServiceProvider::class
    ];

    /**
     * 验证签名
     *
     * @param array $params
     * @param string $key
     * @return bool
     */
    public function checkSign(array $params, $key = null)
    {
        if(!isset($params[Action::TYPE_SIGN])){
            return false;
        }
        // 获取签名
        $sign = $params[Action::TYPE_SIGN];

        unset($params[Action::TYPE_SIGN]);

        return $this->getSign($params, $key) == $sign;
    }

    /**
     * 生成对客户端的签名
     *
     * @param $product
     * @param $key
     * @param $time
     * @return string
     */
    public function generateSign($time, $product = null, $key = null)
    {
        // 加密值
        $value = http_build_query([
            'time' => $time,
            'product' => $product ? :$this->config->get('product')
        ]);

        // 验签
        return hash_hmac('md5', $value, $key ?:$this->config->get('key'), true);
    }
}