<?php
namespace I3A\Api\Kernel\Traits;

/**
 * Trait AppCryptTrait
 * @package I3A\Api\Kernel\Traits
 */
trait AppCryptTrait
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
        return md5($key ?? $this->config->get('access_key'));
    }

    /**
     * 获取Aes加密盐值
     *
     * @param null $iv
     * @return bool|string
     */
    protected function getAesIv($iv = null)
    {
        return substr(md5($iv ?? $this->config->get('access_key')),0,16);
    }
}