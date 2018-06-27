<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 16:03
 */

namespace OverNick\SimpleDemo\Kernel\Abstracts;

use OverNick\SimpleDemo\Action\UpdateAction;
use OverNick\SimpleDemo\Action\ActiveAction;
use OverNick\SimpleDemo\Kernel\Action;
use OverNick\SimpleDemo\Kernel\ServiceContainer;
use OverNick\Support\Arr;

/**
 * 基础类
 *
 * Class BaseApp
 * @package OverNick\SimpleDemo\Kernel
 */
class BaseAppAbstract extends ServiceContainer
{
    /**
     * @var string
     */
    protected $gateway = 'http://apiserv.i3abox.com/v1/gateway';

    /**
     * 动作列表
     *
     * @var array
     */
    protected $actions = [
        Action::SERVER_UPDATE => UpdateAction::class,
        Action::SERVER_ACTIVE => ActiveAction::class
    ];

    /**
     * Sign
     *
     * @param array $data
     * @param string $key
     * @return string
     */
    public function getSign(array $data, $key = null)
    {
        ksort($data);

        return hash_hmac('sha1', http_build_query($data), $key ? : $this->config->get('key'));
    }

    /**
     * @param $time
     * @return bool|string
     */
    public function getServerSignKey($time)
    {
        return substr(hash_hmac('md5', $time, $this->config->get('key')),0,16);
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