<?php
namespace I3A\Api\Client\Api;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package OverNick\SimpleDemo\Client\Api
 */
class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['api'] = function($app){
            return new Client($app);
        };
    }

}