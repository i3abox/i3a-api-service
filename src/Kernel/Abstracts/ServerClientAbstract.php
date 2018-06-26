<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 17:15
 */

namespace OverNick\SimpleDemo\Kernel\Abstracts;


use OverNick\SimpleDemo\Kernel\Action;
use OverNick\SimpleDemo\Kernel\Traits\HttpRequestTrait;
use Pimple\Container;

abstract class ServerClientAbstract
{
    use HttpRequestTrait;

    /**
     * @var \OverNick\SimpleDemo\Server\App
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
        if (isset($params['url'])){
            $this->app->config->set('url', $params['url']);
            unset($params['url']);
        }

        if (isset($params['key'])){
            $this->app->config->set('key', $params['key']);
            unset($params['key']);
        }

        if (isset($params['product'])){
            $this->app->config->set('product', $params['product']);
            unset($params['product']);
        }

        $params = $this->buildPrams($params);

        $options = array_merge($options, [
            'verify' => false,
            'http_errors' => false,
            'form_params' => $params
        ]);

        $response = $this->getHttpClient()->request($method, $this->app->config->get('url'), $options);

        return $response->getBody()->getContents();
    }

    /**
     * @param array $params
     * @return array
     */
    protected function buildPrams(array $params = [])
    {
        // time
        $params[Action::SERVER_ACTION_TIME] = time();

        // get key
        $paramsKey = $this->app->getServerSignKey($params[Action::SERVER_ACTION_TIME]);

        // sign
        $params[$paramsKey] = $this->app->generateSign($params[Action::SERVER_ACTION_TIME]);

        return $params;
    }

}