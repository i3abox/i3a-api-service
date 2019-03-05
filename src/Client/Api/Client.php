<?php
namespace I3A\Api\Client\Api;

use I3A\Api\Kernel\Abstracts\BaseClientAbstract;

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
        ], 'GET');
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
        ], 'GET');
    }

    /**
     * 通过ip地址查询归属地
     *
     * @param $ip
     * @return bool|mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function ip($ip)
    {
        return $this->apiRequest('gateway/api/ip', [
            'ip' => $ip
        ]);
    }

}