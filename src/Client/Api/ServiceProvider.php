<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/12/25
 * Time: 14:41
 */

namespace OverNick\SimpleDemo\Client\Api;


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