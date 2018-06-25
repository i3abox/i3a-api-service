<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 17:32
 */
namespace OverNick\SimpleDemo\Server\Base;

use OverNick\SimpleDemo\Kernel\Abstracts\ServerClientAbstract;
use OverNick\SimpleDemo\Kernel\Action;

/**
 *
 *
 * Class Client
 * @package OverNick\SimpleDemo\Server\Base
 */
class Client extends ServerClientAbstract
{

    /**
     * 推送更新
     *
     * @param array $params
     * @return string
     * @throws \Exception
     */
    public function updated(array $params = [])
    {
        if(!array_key_exists('zip', $params) || !filter_var($params['zip'], FILTER_VALIDATE_URL)){
            throw new \Exception('params zip not found!');
        }

        $params[Action::SERVER_ACTION_ACTION] = Action::SERVER_UPDATE;

        return $this->request($params);
    }
}