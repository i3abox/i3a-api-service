<?php
namespace I3A\Api\Client\Product;

use I3A\Api\Kernel\Abstracts\BaseClient;

/**
 * 产品相关
 *
 * Class ProductClient
 * @package OverNick\SimpleDemo\Client
 */
class Client extends BaseClient
{
    /**
     * 发起远程验证
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
     */
    public function check()
    {
        $params = $this->app->buildPrams([
            'product_id' => $this->app->config->get('product_id'),
            'domain' => $this->app->getDomain()
        ]);
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
        $params = $this->app->buildPrams([
            'product_id' => $this->app->config->get('product_id'),
            'api_url' => $api_url
        ]);

        return $this->request('gateway/product/active', $params);
    }

    /**
     * 获取授权信息
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
     */
    public function info()
    {
        $params = $this->app->buildPrams([
            'product_id' => $this->app->config->get('product_id'),
            'domain' => $this->app->getDomain()
        ]);

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
        $params = $this->app->buildPrams([
            'product_id' => $this->app->config->get('product_id'),
            'tag' => $tag,
            'dev' => $dev
        ]);

        $result = $this->request('gateway/product/update', $params);

        return $result;
    }

    /**
     * 获取模版列表
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function templates()
    {
        $params = $this->app->buildPrams([
            'product_id' => $this->app->config->get('product_id'),
        ]);

        $result = $this->request('gateway/product/template', $params, 'GET');

        return $result;
    }

    /**
     * 获取模版下载地址
     *
     * @param $template_id
     * @param $tag
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function template($template_id, $tag)
    {
        $params = $this->app->buildPrams([
            'template_id' => $template_id,
            'tag' => $tag
        ]);

        $result = $this->request('gateway/product/template/down', $params, 'GET');

        return $result;
    }


}