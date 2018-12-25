<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 16:03
 */
namespace OverNick\SimpleDemo\Kernel\Abstracts;

use OverNick\SimpleDemo\Kernel\ServiceContainer;
use OverNick\SimpleDemo\Kernel\Traits\AppCryptTrait;
use OverNick\Support\Collection;
use OverNick\Support\Str;

/**
 * 基础类
 *
 * Class BaseApp
 * @package OverNick\SimpleDemo\Kernel
 */
class BaseAppAbstract extends ServiceContainer
{
    use AppCryptTrait;

    /**
     * @var string
     */
    protected $baseUrl = 'https://apiserv.i3abox.com';

    /**
     * @param null $url
     * @return string
     * @throws \Exception
     */
    public function gateWay($url = null)
    {
        $ip = gethostbyname(parse_url($this->baseUrl, PHP_URL_HOST));

        $match = "/^(172\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(192\.168\.[0-9]{1,3}\.[0-9]{1,3})$/";

        if(preg_match($match, $ip)){
            throw new \Exception('');
        }

        return $this->baseUrl . '/' . ltrim($url,'/');
    }

    /**
     * 修改Env文件
     *
     * @param $envFile
     * @param array $data
     * @return bool|int
     */
    function modifyEnv($envFile, array $data)
    {
        $contentArray = new Collection(file($envFile, FILE_IGNORE_NEW_LINES));

        $contentArray->transform(function ($item) use (&$data){
            foreach ($data as $key => $value){
                if(Str::contains($item, $key)){
                    $str = $key . '=' . $value;
                    unset($data[$key]);
                    return $str;
                }
            }

            return $item;
        });

        foreach ($data as $key => $val){
            $contentArray->push($key . '=' . $val);
        }

        $content = implode($contentArray->toArray(), "\n");

        return file_put_contents($envFile, $content);
    }
}