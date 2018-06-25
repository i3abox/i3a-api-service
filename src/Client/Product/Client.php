<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 15:45
 */

namespace OverNick\SimpleDemo\Client\Product;


use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;
use OverNick\SimpleDemo\Kernel\Action;

/**
 * 产品相关
 *
 * Class ProductClient
 * @package OverNick\SimpleDemo\Client
 */
class Client extends BaseClientAbstract
{
    /**
     * 发起远程验证
     *
     * @param array $params
     * @return string
     */
    public function check($params = [])
    {
        $params[Action::TYPE_ACTION] = Action::VERIFY_ACTION;

        return $this->request($params);
    }

    /**
     * 激活产品
     *
     * @param array $params
     * @return string
     */
    public function active($params = [])
    {
        $params[Action::TYPE_ACTION] = Action::ACTIVE_ACTION;

        return $this->request($params);
    }

    /**
     * 获取授权信息
     *
     * @param array $params
     * @return string
     */
    public function info($params = [])
    {
        $params[Action::TYPE_ACTION] = Action::INFO_ACTION;

        return $this->request($params);
    }

}