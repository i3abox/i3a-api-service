<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 18:21
 */

namespace OverNick\SimpleDemo\Kernel;

/**
 * Class Action
 * @package OverNick\SimpleDemo\Kernel
 */
class Action
{
    const SUCCESS_KEY = 'Success';
    const FAIL_KEY = 'Fail';

    /**
     * 服务端提交参数
     */
    const SERVER_UPDATE = 'update';

    const SERVER = [
        self::SERVER_UPDATE => '推送更新'
    ];
}