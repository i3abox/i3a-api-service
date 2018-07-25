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
 * @property \OverNick\SimpleDemo\Client\Backend\Client $backend
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
        Update\ServiceProvider::class,
        Backend\ServiceProvider::class
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
     * 解密数据
     *
     * @param $result
     * @return mixed
     */
    public function deCrypt($result)
    {
        return unserialize(AES::decrypt($result['data'], $this->getAesKey(), $this->getAesIv()));
    }

    /**
     * 加密数据
     *
     * @param $data
     * @param $key
     * @param $iv
     * @return string
     */
    public function crypt($data, $key = null, $iv = null)
    {
        return base64_encode(AES::encrypt(serialize($data), $this->getAesKey($key) , $this->getAesIv($iv)));
    }

    /**
     * 获取Aes加密Key
     *
     * @param null $key
     * @return string
     */
    protected function getAesKey($key = null)
    {
        return $key ?? md5($this->config->get('key'));
    }

    /**
     * 获取Aes加密盐值
     *
     * @param null $iv
     * @return bool|string
     */
    protected function getAesIv($iv = null)
    {
        return $iv ?? substr(md5($this->config->get('key')),0,16);
    }

}