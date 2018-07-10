<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 17:42
 */
namespace OverNick\SimpleDemo\Client;

use Closure;
use OverNick\SimpleDemo\Action\BaseActionAbstract;
use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;
use OverNick\SimpleDemo\Kernel\Abstracts\BaseAppAbstract;
use OverNick\Support\AES;

/**
 * Class AuthManage
 *
 * @property \OverNick\SimpleDemo\Client\Product\Client $product
 * @property \OverNick\SimpleDemo\Client\Update\Client $update
 *
 * @package OverNick\SimpleDemo
 */
class App extends BaseAppAbstract
{
    /**
     * @var array
     */
    protected $providers = [
        Product\ServiceProvider::class,
        Update\ServiceProvider::class
    ];

    /**
     * verify sign
     *
     * @param string $time
     * @param string $sign
     * @return bool
     */
    public function checkServerSign($time, $sign)
    {
        // 加密值
        $value = http_build_query([
            'time' => $time,
            'product' => $this->config->get('product')
        ]);

        // 验签
        return hash_hmac('md5', $value, $this->config->get('key'), true) == $sign;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function gateWay()
    {
        $ip = gethostbyname(parse_url($this->gateway, PHP_URL_HOST));

        $match = "/^(172\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(192\.168\.[0-9]{1,3}\.[0-9]{1,3})$/";

        if(preg_match($match, $ip)){
            throw new \Exception('');
        }

        return $this->gateway;
    }

    /**
     * @param Closure $callback
     * @return mixed
     */
    public function verify(Closure $callback)
    {
        return $callback($this);
    }

    /**
     * @param $result
     * @return bool
     */
    public function hasSuccess($result)
    {
        return isset($result['errcode']) && $result['errcode'] === 0;
    }

    /**
     * 获取数据
     *
     * @param $result
     * @return mixed
     */
    public function getData($result)
    {
        return unserialize(AES::decrypt($result['data'], md5($this->app->config->get('key')),substr($this->app->config->get('key'),0,16)));
    }

}