<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/12/25
 * Time: 14:34
 */
namespace OverNick\SimpleDemo\Client\Api;

use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;

/**
 * 接口
 *
 * Class Client
 * @package OverNick\SimpleDemo\Client\Api
 */
class Client extends BaseClientAbstract
{
    /**
     * 查询接口权限是否开通
     *
     * @param string $as 接口名称
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function has($as)
    {
        return $this->apiRequest("gateway/api/{$as}/has", [], 'GET');
    }

    /**
     * 开通接口权限
     *
     * @param string $as 接口名称
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function open($as)
    {
        return $this->apiRequest("gateway/api/{$as}/open");
    }

    /**
     * 快递查询
     *
     * @param string $code 快递代码
     * @param string $num  快递单号
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function express($code, $num)
    {
        return $this->apiRequest('gateway/api/express', [
            'code' => $code,
            'num' => $num
        ]);
    }

    /**
     * 企业图谱信息查询
     *
     * @param $com
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function companyMap($com)
    {
        return $this->apiRequest('gateway/api/company/map', [
            'com' => $com
        ]);
    }

}