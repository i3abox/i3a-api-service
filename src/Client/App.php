<?php
namespace I3A\Api\Client;

use I3A\Api\Kernel\Abstracts\BaseAppAbstract;
use OverNick\Support\Arr;
use OverNick\Support\Str;

/**
 * Class AuthManage
 *
 * @property \I3A\Api\Client\Product\Client $product
 * @property \I3A\Api\Client\User\Client $user
 *
 * @package OverNick\SimpleDemo
 */
class App extends BaseAppAbstract
{
    /**
     * @var array
     */
    protected $providers = [
        Product\ServiceProvider::class,
        User\ServiceProvider::class,
        Api\ServiceProvider::class
    ];

    /**
     * 签名
     *
     * @return string
     */
    public function buildSign()
    {
        $sign = [
            'access_id' => $this->config->get('access_id'),
            'time' => time()
        ];
        $sign['access_key'] = hash_hmac('sha1',http_build_query($sign), $this->config->get('access_key'));
        return implode('', $sign);
    }

    /**
     * @param array $params
     * @return array
     */
    public function buildPrams(array $params = [])
    {
        return ['biz_content' => $this->crypt($params, $this->config->get('access_key'))];
    }

    /**
     * get auth domain
     *
     * @return mixed
     */
    public function getDomain()
    {
        $domain = Arr::get($_SERVER, 'HTTP_X_FORWARDED_HOST', Arr::get($_SERVER, 'HTTP_HOST'));

        if(empty($domain) || filter_var($domain, FILTER_VALIDATE_IP)){
            $domain = $this->config->get('domain');
        }

        return $domain;
    }

    /**
     * 更新文件
     *
     * @param string $zipFileUrl 解压包远程路径
     * @return bool
     * @throws \Exception
     */
    public function up($zipFileUrl)
    {
        // 生成本地文件路径
        $filePath = $this->config->get('storage_path').'/'.Str::random().'.zip';

        // 文件执行情况
        $result = file_put_contents($filePath, file_get_contents($zipFileUrl));

        if(!$result){
            throw new \Exception('file download fail');
        }

        // 实例化下载类
        $zip = new \ZipArchive();

        // 获取资源
        $res =  $zip->open($filePath);

        if(!$res){
            throw new \Exception('file open fail');
        }

        // 解压到指定目录
        if(!$zip->extractTo($this->app->config->get('base_path'))){
            throw new \Exception('zip fail');
        }

        // 关闭资源
        $zip->close();

        unlink($filePath);

        return true;
    }
}