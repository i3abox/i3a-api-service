<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 18:00
 */
namespace OverNick\Auth\Kernel\Abstracts;

use OverNick\Auth\Kernel\Action;
use OverNick\Auth\Kernel\Traits\HttpRequestTrait;
use Pimple\Container;

/**
 * Class BaseClientAbstract
 * @package OverNick\Auth\Kernel\Abstracts
 */
abstract class BaseClientAbstract
{
    use HttpRequestTrait;

    /**
     * @var \OverNick\Auth\Client\App
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
        $params[Action::TYPE_DOMAIN] = $_SERVER['SERVER_NAME'];
        $params[Action::TYPE_CIPHER] = $this->app->config->get('cipher');
        $params[Action::TYPE_UID] = $this->app->config->get('access_id');
        $params[Action::TYPE_PRODUCT] = $this->app->config->get('product');
        $params[Action::TYPE_TIME] = time();
        $params[Action::TYPE_SIGN] = $this->app->getSign($params);
        return $params;
    }
}