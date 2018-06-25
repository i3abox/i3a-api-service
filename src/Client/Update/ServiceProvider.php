<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 15:41
 */
namespace OverNick\SimpleDemo\Client\Update;

use OverNick\SimpleDemo\Client\Update\Client;
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
        $pimple['update'] = function() use($pimple){
            return new Client($pimple);
        };
    }
}