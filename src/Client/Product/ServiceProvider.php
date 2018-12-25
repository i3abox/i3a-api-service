<?php
namespace I3A\Api\Client\Product;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 产品
 *
 * Class ActiveServiceProvider
 * @package OverNick\SimpleDemo\Providers
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['product'] = function() use($pimple){
            return new Client($pimple);
        };
    }
}