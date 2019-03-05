<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 18:00
 */
namespace I3A\Api\Kernel\Abstracts;

use I3A\Api\Kernel\Traits\HttpRequestTrait;
use Pimple\Container;

/**
 * Class BaseClientAbstract
 * @package OverNick\SimpleDemo\Kernel\Abstracts
 */
abstract class BaseClientAbstract
{
    use HttpRequestTrait;

    /**
     * @var \I3A\Api\Client\App
     */
    protected $app;

    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    /**
     * 接口请求
     *
     * @param $url
     * @param array $params
     * @param string $method
     * @param array $options
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function apiRequest($url, array $params = [], $method = 'POST', array $options = [])
    {
        $options = array_merge($options, [
            'verify' => false,
            'http_errors' => false,
            strtoupper($method) == 'GET' ? 'query' : 'form_params' => $params,
            'headers' => [
                'I3A-AUTH' => $this->app->buildSign()
            ]
        ]);

        $response = $this->getHttpClient()->request($method, $this->app->gateWay($url), $options);

        if($response->getStatusCode() !== 200){
            return false;
        }

        $result = $response->getBody()->getContents();

        return json_decode($result, true);
    }

    /**
     * @param $url
     * @param array $params
     * @param string $method
     * @param array $options
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException | \Exception
     */
    public function request($url, array $params = [], $method = 'POST', array $options = [])
    {
        $params = $this->app->buildPrams($params);

        $options = array_merge($options, [
            'verify' => false,
            'http_errors' => false,
            'form_params' => $params,
            'headers' => [
                'I3A-AUTH' => $this->app->buildSign()
            ]
        ]);

        $response = $this->getHttpClient()->request($method, $this->app->gateWay($url), $options);

        if($response->getStatusCode() !== 200){
            return false;
        }

        $result = $response->getBody()->getContents();

        return json_decode($result, true);
    }
}