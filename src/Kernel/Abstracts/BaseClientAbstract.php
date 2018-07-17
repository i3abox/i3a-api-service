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
     * @param array $params
     * @param string $method
     * @param array $options
     * @return string
     */
    public function request(array $params = [], $method = 'POST', array $options = [])
    {
        $params = $this->buildPrams($params);

        $options = array_merge($options, [
            'verify' => false,
            'http_errors' => false,
            'form_params' => $params
        ]);

        $response = $this->getHttpClient()->request($method, $this->app->gateWay(), $options);

        $result = $response->getBody()->getContents();

        return json_decode($result, true);
    }

    /**
     * @param array $params
     * @return array
     */
    protected function buildPrams(array $params = [])
    {
        $params[Action::TYPE_DOMAIN] = $this->app->config->get('domain', Arr::get($_SERVER,'SERVER_NAME', Arr::get($_SERVER, 'HTTP_HOST', 'localhost')));
        $params[Action::TYPE_CIPHER] = $this->app->config->get('cipher');
        $params[Action::TYPE_UID] = $this->app->config->get('access_id');
        $params[Action::TYPE_PRODUCT] = $this->app->config->get('product');
        $params[Action::TYPE_TIME] = time();
        $params[Action::TYPE_SIGN] = $this->app->getSign($params);
        return $params;
    }
}