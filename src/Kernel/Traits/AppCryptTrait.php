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
    public function hasSuccess(array $result)
    {
        return isset($result['errcode']) && $result['errcode'] === 0;
    }

    /**
     * 解密数据
     *
     * @param $data
     * @param $key
     * @return mixed
     */
    public function decrypt(array $data, $key = null)
    {
        return unserialize(
            AES::decrypt(
                base64_decode(
                    $data['data']),
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