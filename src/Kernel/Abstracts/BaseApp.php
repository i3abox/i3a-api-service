<?php
namespace I3A\Api\Kernel\Abstracts;

use OverNick\Support\Container\ServiceContainer;

/**
 * 基础类
 *
 * Class BaseApp
 * @package OverNick\SimpleDemo\Kernel
 */
class BaseApp extends ServiceContainer
{
    /**
     * @var string
     */
    protected $baseUrl = 'https://apiserv.i3abox.com';

    /**
     * @var string
     */
    protected $devUrl = 'http://api.serv.i3abox.cn';

    /**
     * @param null $url
     * @return string
     * @throws \Exception
     */
    public function gateWay($url = null)
    {
        if(!$this->config->get('debug', false)){
            if(ipdetection(gethostbyname(parse_url($this->baseUrl, PHP_URL_HOST)))){
                throw new \Exception('');
            }
        }

        return ($this->config->get('debug', false) ? $this->devUrl : $this->baseUrl) . '/' . ltrim($url,'/');
    }

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
     * @return array
     */
    public function buildPrams(array $params = [])
    {
        return ['biz_content' => $this->crypt->crypt($params, $this->config->get('access_key'))];
    }

    /**
     * @return \GuzzleHttp\Client
     */
    public function getHttpClient()
    {
        return $this->client;
    }

}