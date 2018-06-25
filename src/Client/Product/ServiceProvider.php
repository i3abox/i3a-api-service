<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 15:43
 */
namespace OverNick\Auth\Client\Product;

use OverNick\Auth\Client\Product\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 产品
 *
 * Class ActiveServiceProvider
 * @package OverNick\Auth\Providers
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['active'] = function() use($pimple){
            return new Client($pimple);
        };
    }
}