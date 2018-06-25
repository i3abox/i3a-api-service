<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 17:56
 */

namespace OverNick\Auth\Server\Base;


use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 基础服务
 *
 * Class ServiceProvider
 * @package OverNick\Auth\Server\Base
 */
class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['base'] = function() use($pimple){
            return new Client($pimple);
        };
    }

}