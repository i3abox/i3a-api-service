<?php
namespace I3A\Api\Client\User;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 更新程序
 *
 * Class UpdateServiceProvider
 * @package OverNick\SimpleDemo\Providers
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['user'] = function() use($pimple){
            return new Client($pimple);
        };
    }
}