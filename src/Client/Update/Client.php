<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 13:42
 */
namespace OverNick\SimpleDemo\Client\Update;

use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;
use OverNick\Support\Collection;
use OverNick\Support\Str;

/**
 * 更新
 *
 * Class UpdateClient
 * @package OverNick\SimpleDemo\Client
 */
class Client extends BaseClientAbstract
{
    /**
     * 获取版本信息
     *
     * @param mixed|float $tag
     * @return string
     */
    public function info($tag)
    {
        $params = [
            'product_id' => $this->app->config->get('product_id'),
            'tag' => $tag
        ];

        $result = $this->request('gateway/product/update', $params);

        return $result;
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
        if(!filter_var($zipFileUrl, FILTER_VALIDATE_URL)){
            throw new \Exception('file is not zipFile');
        }

        // 生成本地文件路径
        $filePath = $this->app->config->get('storage_path').'/'.Str::random().'.zip';

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