<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/4/16
 * Time: 13:49
 */
namespace I3A\Api\Kernel\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

trait HttpRequestTrait
{
    /**
     * @var ClientInterface
     */
    protected $httpClient = null;

    /**
     * @param ClientInterface $client
     */
    public function setHttpClient(ClientInterface $client)
    {
        $this->httpClient = $client;
    }

    /**
     * @return Client|ClientInterface
     */
    public function getHttpClient()
    {
        if(is_null($this->httpClient)){
            $this->httpClient = array_key_exists('http_client',$this->app) ? $this->app['http_client'] : new Client();;
        }

        return $this->httpClient;
    }

    /**
     * 发送请求
     * @param string $method
     * @param $url
     * @param $options
     * @return \Psr\Http\Message\StreamInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function httpRequest($method = 'GET', $url, $options)
    {
        $response = $this->getHttpClient()->request($method, $url, $options);

        return $response->getBody();
    }

}