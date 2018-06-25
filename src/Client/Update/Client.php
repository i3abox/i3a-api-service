<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 13:42
 */
namespace OverNick\Auth\Client\Update;

use OverNick\Auth\Kernel\Abstracts\BaseClientAbstract;
use OverNick\Auth\Kernel\Action;
use OverNick\Support\Str;

/**
 * 更新
 *
 * Class UpdateClient
 * @package OverNick\Auth\Client
 */
class Client extends BaseClientAbstract
{
    /**
     * 获取版本信息
     *
     * @param array $params
     * @return string
     */
    public function info(array $params = [])
    {
        $params['a'] = Action::UPDATE_ACTIVE;

        $result = $this->request($params);

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
        if(!preg_match('/http:\/\/.*\/.*(\.zip)$/', $zipFileUrl)){
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
}