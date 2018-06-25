<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/14
 * Time: 16:57
 */
namespace OverNick\SimpleDemo\Kernel\Providers;

use GuzzleHttp\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Guzzle Client Register
 *
 * Class ClientServiceProvider
 * @package OverNick\Payment\Kernel\Providers
 */
class ClientServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['http_client'] = function(){
            return new Client();
        };
    }
}