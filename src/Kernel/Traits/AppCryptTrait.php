<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/7/25
 * Time: 15:29
 */
namespace OverNick\SimpleDemo\Kernel\Traits;

use OverNick\Support\AES;
use OverNick\Support\Arr;

trait AppCryptTrait
{

    /**
     * @param $result
     * @return bool
     */
    public function hasSuccess(array $result)
    {
        return isset($result['errcode']) && $result['errcode'] === 0;
    }

    /**
     * 获取数据
     *
     * @param array $result
     * @param null $key
     * @return mixed|null
     */
    public function getData(array $result, $key = null)
    {
        if(!$this->hasSuccess($result)) return null;

        return $this->decrypt(Arr::get($result, 'data'), $key);
    }

    /**
     * 解密数据
     *
     * @param $data
     * @param $key
     * @return mixed
     */
    public function decrypt($data, $key = null)
    {
        return unserialize(
            AES::decrypt(
                base64_decode(
                    $data),
                    $this->getAesKey($key),
                    $this->getAesIv($key)
                )
            );
    }

    /**
     * 加密数据
     *
     * @param $data
     * @param $key
     * @return string
     */
    public function crypt($data, $key = null)
    {
        return base64_encode(
            AES::encrypt(
                serialize($data),
                $this->getAesKey($key),
                $this->getAesIv($key)
            )
        );
    }

    /**
     * 获取Aes加密Key
     *
     * @param null $key
     * @return string
     */
    public function getAesKey($key = null)
    {
        return md5($key ?? $this->config->get('access_key'));
    }

    /**
     * 获取Aes加密盐值
     *
     * @param null $iv
     * @return bool|string
     */
    public function getAesIv($iv = null)
    {
        return substr(md5($iv ?? $this->config->get('access_key')),0,16);
    }
}