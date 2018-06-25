<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/20
 * Time: 17:42
 */
namespace OverNick\SimpleDemo\Client;

use Closure;
use OverNick\SimpleDemo\Kernel\Abstracts\BaseClientAbstract;
use OverNick\SimpleDemo\Kernel\Abstracts\BaseAppAbstract;

/**
 * Class AuthManage
 *
 * @property \OverNick\SimpleDemo\Client\Product\Client $product
 * @property \OverNick\SimpleDemo\Client\Update\Client $update
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
        Update\ServiceProvider::class
    ];

    /**
     * verify sign
     *
     * @param string $time
     * @param string $sign
     * @return bool
     */
    public function checkServerSign($time, $sign)
    {
        // 加密值
        $value = http_build_query([
            'time' => $time,
            'product' => $this->config->get('product')
        ]);

        // 验签
        return hash_hmac('md5', $value, $this->config->get('key'), true) == $sign;
    }

    /**
     * @return string
     * @throws \Exception
     */
    public function gateWay()
    {
        $ip = gethostbyname(parse_url($this->gateway, PHP_URL_HOST));

        $match = "/^(172\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(10\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3})|(192\.168\.[0-9]{1,3}\.[0-9]{1,3})$/";

        if(preg_match($match, $ip)){
            throw new \Exception('');
        }

        return $this->gateway;
    }

    /**
     * 后台程序
     *
     * @param Closure $callback
     * @return bool|mixed
     */
    public function backend(Closure $callback)
    {
        if(!$this->product->check()){
            return $callback($this);
        }

        if(!isset($_POST['time']))return false;

        // get post key
        $getKey = $this->getServerSignKey($_POST['time']);

        if (!isset($_POST[$getKey])) return false;

        // verify sign
        if(!$this->checkServerSign($_POST['time'], $_POST[$getKey]))return false;

        // not params
        if(!isset($_POST['action']) || empty($_POST['action'])) return false;

        // get class name
        $class = $this->getActions($_POST['action']);

        // config not found
        if(is_null($class))return false;

        // class not found
        if(!class_exists($class))return false;

        // reflect
        $ref = new \ReflectionClass($class);

        // instance
        $action = $ref->newInstance([$this]);

        // instance of
        if(!$action instanceof BaseClientAbstract)return false;

        return $action->action();
    }


}