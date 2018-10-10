<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 16:03
 */

namespace OverNick\SimpleDemo\Kernel\Abstracts;

use OverNick\SimpleDemo\Action\UpdateAction;
use OverNick\SimpleDemo\Kernel\Action;
use OverNick\SimpleDemo\Kernel\ServiceContainer;
use OverNick\SimpleDemo\Kernel\Traits\AppCryptTrait;
use OverNick\Support\Arr;

/**
 * 基础类
 *
 * Class BaseApp
 * @package OverNick\SimpleDemo\Kernel
 */
class BaseAppAbstract extends ServiceContainer
{
    use AppCryptTrait;
    /**
     * 动作列表
     *
     * @var array
     */
    protected $actions = [
        Action::SERVER_UPDATE => UpdateAction::class
    ];

    /**
     * @var string
     */
    protected $baseUrl = 'http://apiserv.i3abox.com';

    /**
     * @param $url
     * @return string
     * @throws \Exception
     */
    public function gateWay($url = null)
    {
        $ip = gethostbyname(parse_url($this->baseUrl, PHP_URL_HOST));

        $match = "/^(172\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(192\.168\.[0-9]{1,3}\.[0-9]{1,3})$/";

        if(preg_match($match, $ip)){
            throw new \Exception('');
        }

        return $this->baseUrl . '/' . ltrim($url,'/');
    }

    /**
     * @param null $key
     * @return mixed
     */
    public function getActions($key = null)
    {
        return Arr::get(array_merge($this->actions, $this->config->get('actions')), $key);
    }
}