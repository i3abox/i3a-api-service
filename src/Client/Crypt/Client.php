<?php
namespace I3A\Api\Client\Crypt;

use I3A\Api\Kernel\Abstracts\BaseClient;
use OverNick\Support\AES;

/**
 * 加密组件
 *
 * Class Client
 * @package I3A\Api\Client\Crypt
 */
class Client extends BaseClient
{
    /**
     * 解密数据
     *
     * @param $data
     * @param $key
     * @return mixed
     */
    public function decrypt($data, $key = null)
    {
        return unserialize(openssl_decrypt(
            hex2bin($data),
            $this->getMode($this->getAesKey($key)),
            $this->getAesKey($key),
            OPENSSL_RAW_DATA,
            $this->getAesIv($key)
        ));
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
        return bin2hex(openssl_encrypt(
            serialize($data),
            $this->getMode($this->getAesKey($key)),
            $this->getAesKey($key),
            OPENSSL_RAW_DATA,
            $this->getAesIv($key)
        ));
    }

    /**
     * @param string $key
     *
     * @return string
     */
    protected function getMode($key)
    {
        return 'aes-'.(8 * strlen($key)).'-cbc';
    }

    /**
     * 获取Aes加密Key
     *
     * @param null $key
     * @return string
     */
    protected function getAesKey($key = null)
    {
        return md5($key ?? $this->app->config->get('access_key'));
    }

    /**
     * 获取Aes加密盐值
     *
     * @param null $iv
     * @return bool|string
     */
    protected function getAesIv($iv = null)
    {
        return substr(md5($iv ?? $this->app->config->get('access_key')),0,16);
    }
}