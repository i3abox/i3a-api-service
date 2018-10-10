<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 18:00
 */
namespace OverNick\SimpleDemo\Kernel\Abstracts;

use OverNick\SimpleDemo\Kernel\Action;
use OverNick\SimpleDemo\Kernel\Traits\HttpRequestTrait;
use OverNick\Support\AES;
use OverNick\Support\Arr;
use Pimple\Container;

/**
 * Class BaseClientAbstract
 * @package OverNick\SimpleDemo\Kernel\Abstracts
 */
abstract class BaseClientAbstract
{
    use HttpRequestTrait;

    /**
     * @var \OverNick\SimpleDemo\Client\App
     */
    protected $app;

    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    /**
     * @param string $url
     * @param array $params
     * @param string $method
     * @param array $options
     * @return string
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

        $result = $response->getBody()->getContents();

        return json_decode($result, true);
    }
}