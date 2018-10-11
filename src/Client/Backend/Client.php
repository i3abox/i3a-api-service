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
     * 验证是否是开发者角色
     *
     * @return string
     */
    public function hasDev()
    {
       return $this->request('gateway/check/develop');
    }

    /**
     * 后台程序
     *
     * @return bool|mixed
     */
    public function run()
    {
        if(!isset($_SERVER['BACKEND_AUTH']))return false;

        $data = explode(":", $_SERVER['BACKEND_AUTH']);

        if(!is_array($data) || count($data) !== 3) return false;

        list($action, $time, $sign) = $data;

        if($time <= time() - 300)return false;

        $result = $this->check($action, $time, $sign);

        if(!$this->app->hasSuccess(json_decode($result->getBody()->getContents()))) return false;

        // not params
        if(!isset($action) || empty($action)) return false;

        // get class name
        $class = $this->app->getActions($action);

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

    /**
     * @param $action
     * @param $time
     * @param $sign
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function check($action, $time, $sign)
    {
        return $this->getHttpClient()->post($this->app->gateWay('gateway/check/sign'), [
            'verify' => false,
            'http_errors' => false,
            'form_params' => [
                'action' => $action,
                'time' => $time,
                'sign' => $sign
            ]
        ]);
    }
}