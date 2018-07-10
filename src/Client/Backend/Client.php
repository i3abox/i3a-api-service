<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/7/10
 * Time: 11:35
 */

namespace OverNick\SimpleDemo\Client\Backend;

use OverNick\SimpleDemo\Action\BaseActionAbstract;
use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;

/**
 * 后台
 *
 * Class Client
 * @package OverNick\SimpleDemo\Client\Backend
 */
class Client extends BaseClientAbstract
{
    /**
     * 后台程序
     *
     * @return bool|mixed
     */
    public function backend()
    {
        if(!isset($_POST['time']))return false;

        if($_POST['time'] <= time() - 300)return false;

        // get post key
        $getKey = $this->app->getServerSignKey($_POST['time']);

        if (!isset($_POST[$getKey])) return false;

        // verify sign
        if(!$this->app->checkServerSign($_POST['time'], $_POST[$getKey]))return false;

        // not params
        if(!isset($_POST['action']) || empty($_POST['action'])) return false;

        // get class name
        $class = $this->app->getActions($_POST['action']);

        // config not found
        if(is_null($class))return false;

        // class not found
        if(!class_exists($class))return false;

        // reflect
        $ref = new \ReflectionClass($class);

        // instance
        $action = $ref->newInstance([$this]);

        // instance of
        if(!$action instanceof BaseActionAbstract)return false;

        return $action->action();
    }
}