<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 18:21
 */

namespace OverNick\Auth\Kernel;

/**
 * Class Action
 * @package OverNick\Auth\Kernel
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

    /**
     *  客户端提交参数
     */
    const SERVER_ACTION_ACTION = 'action';
    const SERVER_ACTION_TIME = 'time';

    const SERVER_ACTION = [
        self::SERVER_ACTION_ACTION => '动作',
        self::SERVER_ACTION_TIME => '时间'
    ];

    /**
     * 客户端动作
     */
    const VERIFY_ACTION = 'verify';
    const ACTIVE_ACTION = 'active';
    const INFO_ACTION = 'info';
    const UPDATE_ACTIVE = 'update';

    const ACTION = [
        self::VERIFY_ACTION => '产品验证',
        self::ACTIVE_ACTION => '产品激活',
        self::INFO_ACTION => '获取产品信息',
        self::UPDATE_ACTIVE => '产品升级'
    ];

    /*
     * 客户端提交参数
     */
    const TYPE_ACTION = 'a';
    const TYPE_DOMAIN = 'd';
    const TYPE_CIPHER = 'c';
    const TYPE_UID = 'u';
    const TYPE_PRODUCT = 'p';
    const TYPE_TIME = 't';
    const TYPE_SIGN = 's';

    const TYPE = [
        self::TYPE_ACTION => '动作',
        self::TYPE_DOMAIN => '域名',
        self::TYPE_CIPHER => '加密方式',
        self::TYPE_UID => 'UID',
        self::TYPE_PRODUCT => '产品',
        self::TYPE_TIME => '时间',
        self::TYPE_SIGN => '签名'
    ];

}