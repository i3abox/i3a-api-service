<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2019/3/6
 * Time: 10:04
 */
namespace I3A\Api\Client\Crypt;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package I3A\Api\Client\Crypt
 */
class ServiceProvider implements ServiceProviderInterface
{

    public function register(Container $pimple)
    {
        $pimple['crypt'] = function($pimple){
            return new Client($pimple);
        };
    }

}