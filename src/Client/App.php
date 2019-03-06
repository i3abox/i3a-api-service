<?php
namespace I3A\Api\Client;

use I3A\Api\Kernel\Abstracts\BaseApp;
use OverNick\Support\Arr;

/**
 * Class AuthManage
 *
 * @property \OverNick\Support\Config $config
 * @property \I3A\Api\Client\Product\Client $product
 * @property \I3A\Api\Client\User\Client $user
 * @property \I3A\Api\Client\Api\Client $api
 * @property \I3A\Api\Client\Crypt\Client $crypt
 *
 * @package OverNick\SimpleDemo
 */
class App extends BaseApp
{
    /**
     * @var array
     */
    protected $providers = [
        Product\ServiceProvider::class,
        User\ServiceProvider::class,
        Api\ServiceProvider::class,
        Crypt\ServiceProvider::class
    ];

    /**
     * get auth domain
     *
     * @return mixed
     */
    public function getDomain()
    {
        $domain = Arr::get($_SERVER, 'HTTP_X_FORWARDED_HOST', Arr::get($_SERVER, 'HTTP_HOST'));

        if(empty($domain) || filter_var($domain, FILTER_VALIDATE_IP)){
            $domain = $this->config->get('domain');
        }

        return $domain;
    }

    /**
     * @param $result
     * @return bool
     */
    public function hasSuccess(array $result)
    {
        return isset($result['errcode']) && $result['errcode'] === 0;
    }

    /**
     * 获取数据
     *
     * @param array $result
     * @param null $key
     * @return mixed|null
     */
    public function getData(array $result, $key = null)
    {
        if(!$this->hasSuccess($result)) return null;

        return $this->crypt->decrypt(Arr::get($result, 'data'), $key);
    }
}