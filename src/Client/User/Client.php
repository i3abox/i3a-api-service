<?php
namespace I3A\Api\Client\User;

use I3A\Api\Kernel\Abstracts\BaseClientAbstract;

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