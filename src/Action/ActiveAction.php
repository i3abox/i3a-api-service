<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/27
 * Time: 10:49
 */

namespace OverNick\SimpleDemo\Action;

/**
 * Class ActiveAction
 * @package OverNick\SimpleDemo\Action
 */
class ActiveAction extends BaseActionAbstract
{
    /**
     * @return bool
     */
    public function action()
    {
        if(!isset($_POST['env'])){
            return false;
        }

        try{
            // 文件内容
            $env = unserialize(base64_decode($_POST['env']));
            // 更新内容
            $this->app->update->modifyEnv(rtrim($this->app->config->get('base_path'),'/').'/.env', $env);

            $this->rspSuc();
        }catch (\Exception $exception){
            $this->rspFail();
        }
    }
}