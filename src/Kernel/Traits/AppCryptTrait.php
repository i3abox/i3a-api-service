<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/7/25
 * Time: 15:29
 */

namespace OverNick\SimpleDemo\Kernel\Traits;


use OverNick\Support\AES;

trait AppCryptTrait
{

    /**
     * @param $result
     * @return bool
     */
    public function hasSuccess($result)
    {
        return isset($result['errcode']) && $result['errcode'] === 0;
    }

    /**
     * 解密数据
     *
     * @param $result
     * @return mixed
     */
    public function decrypt($result)
    {
        return unserialize(AES::decrypt(base64_decode($result['data']), $this->getAesKey(), $this->getAesIv()));
    }

    /**
     * 加密数据
     *
     * @param $data
     * @param $key
     * @param $iv
     * @return string
     */
    public function crypt($data, $key = null, $iv = null)
    {
        return base64_encode(AES::encrypt(serialize($data), $this->getAesKey($key) , $this->getAesIv($iv)));
    }

    /**
     * 获取Aes加密Key
     *
     * @param null $key
     * @return string
     */
    public function getAesKey($key = null)
    {
        return md5($key ?? $this->config->get('key'));
    }

    /**
     * 获取Aes加密盐值
     *
     * @param null $iv
     * @return bool|string
     */
    public function getAesIv($iv = null)
    {
        return substr(md5($iv ?? $this->config->get('key')),0,16);
    }
}