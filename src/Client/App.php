<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 17:42
 */
namespace OverNick\SimpleDemo\Client;

use Closure;
use OverNick\SimpleDemo\Kernel\Abstracts\BaseAppAbstract;

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
     * 签名
     *
     * @return string
     */
    public function buildSign()
    {
        $sign = [
            'access_id' => $this->config->get('access_id'),
            'time' => time()
        ];
        $sign['access_key'] = hash_hmac('sha1',http_build_query($sign), $this->config->get('access_key'));
        return implode('', $sign);
    }

    /**
     * @param array $params
     * @return string
     */
    public function buildPrams(array $params = [])
    {
        return $this->crypt(['biz_content' => $params], $this->config->get('access_key'));
    }


    /**
     * @param Closure $callback
     * @return mixed
     */
    public function verify(Closure $callback)
    {
        return $callback($this);
    }
}