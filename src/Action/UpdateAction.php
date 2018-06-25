<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 17:38
 */

namespace OverNick\Auth\Action;

/**
 * 更新推送文件
 *
 * Class UpdateAction
 * @package OverNick\Auth\Action
 */
class UpdateAction extends BaseActionAbstract
{
    /**
     * @return bool
     */
    public function action()
    {
        if(!isset($_POST['zip'])){
            return false;
        }
         try{
             $this->app->update->up($_POST['zip']);
             $this->rspSuc();
         }catch (\Exception $exception){
            return false;
         }
    }
}