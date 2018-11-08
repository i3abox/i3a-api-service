<?php
namespace OverNick\SimpleDemo\Client\Product;

use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;
use OverNick\Support\Arr;

/**
 * 产品相关
 *
 * Class ProductClient
 * @package OverNick\SimpleDemo\Client
 */
class Client extends BaseClientAbstract
{
    /**
     * 发起远程验证
     *
     * @return string
     */
    public function check()
    {
        $params = [
            'product_id' => $this->app->config->get('product_id'),
            'domain' => $this->app->getDomain()
        ];

        return $this->request('gateway/product/verify', $params);
    }

    /**
     * 激活产品
     *
     * @param string $api_url
     * @return string
     */
    public function active($api_url)
    {
        return $this->request('gateway/product/active', [
            'product_id' => $this->app->config->get('product_id'),
            'api_url' => $api_url
        ]);
    }

    /**
     * 获取授权信息
     *
     * @return string
     */
    public function info()
    {
        $params = [
            'product_id' => $this->app->config->get('product_id'),
            'domain' => $this->app->getDomain()
        ];

        return $this->request('gateway/product/info', $params);
    }

}