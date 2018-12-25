<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 13:42
 */
namespace OverNick\SimpleDemo\Client\User;

use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;

/**
 * 用户信息
 *
 * Class Client
 *
 * @package OverNick\SimpleDemo\Client
 */
class Client extends BaseClientAbstract
{
    /**
     * 验证是否是开发者角色
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function hasDev()
    {
        return $this->request('gateway/check/develop');
    }

}