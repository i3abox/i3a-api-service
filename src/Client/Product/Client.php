<?php
namespace I3A\Api\Client\Product;

use I3A\Api\Kernel\Abstracts\BaseClientAbstract;

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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
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
     * @param $api_url
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
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
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
     */
    public function info()
    {
        $params = [
            'product_id' => $this->app->config->get('product_id'),
            'domain' => $this->app->getDomain()
        ];

        return $this->request('gateway/product/info', $params);
    }

    /**
     * 获取版本信息
     *
     * @param $tag
     * @param null $dev
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
     */
    public function version($tag, $dev = null)
    {
        $params = [
            'product_id' => $this->app->config->get('product_id'),
            'tag' => $tag,
            'dev' => $dev
        ];

        $result = $this->request('gateway/product/update', $params);

        return $result;
    }

    /**
     * 获取模版列表
     *
     * @return mixed
     * @throws \Exception
     */
    public function templates()
    {
        $params = [
            'product_id' => $this->app->config->get('product_id'),
        ];

        $result = $this->request('gateway/product/template', $params, 'GET');

        return $result;
    }

    /**
     * 获取模版
     *
     * @param $tag
     * @return mixed
     * @throws \Exception
     */
    public function template($tag)
    {
        $params = [
            'product_id' => $this->app->config->get('product_id'),
            'tag' => $tag
        ];

        $result = $this->request('gateway/product/template/down', $params, 'GET');

        return $result;
    }


}