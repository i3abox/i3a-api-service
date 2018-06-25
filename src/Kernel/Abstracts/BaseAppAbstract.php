<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 16:03
 */

namespace OverNick\Auth\Kernel\Abstracts;

use OverNick\Auth\Kernel\Action;
use OverNick\Auth\Kernel\ServiceContainer;
use OverNick\Support\Arr;

/**
 * 基础类
 *
 * Class BaseApp
 * @package OverNick\Auth\Kernel
 */
class BaseAppAbstract extends ServiceContainer
{
    /**
     * @var string
     */
    protected $gateway = 'http://apiserv.i3abox.com/v1/gateway';

    protected $actions = [
        Action::SERVER_UPDATE => \OverNick\Auth\Action\UpdateAction::class,
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

        return hash_hmac('sha1', http_build_query($data), $key ? : $this->app->config->get('key'));
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