<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/7/10
 * Time: 11:38
 */

namespace OverNick\SimpleDemo\Client\Backend;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 *  后台程序
 *
 * Class ServiceProvider
 * @package OverNick\SimpleDemo\Client\Backend
 */
class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['backend'] = function ($app){
            return new Client($app);
        };
    }
}