<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/21
 * Time: 16:44
 */
namespace OverNick\SimpleDemo\Action;

use OverNick\SimpleDemo\Kernel\Action;
use Pimple\Container;

/**
 * Class BaseActionAbstract
 * @package OverNick\SimpleDemo\Action
 */
abstract class BaseActionAbstract
{
    /**
     * @var \OverNick\SimpleDemo\Client\App
     */
    protected $app;

    public function __construct(Container $container)
    {
        $this->app = $container;
    }

    abstract public function action();

    // success
    protected function rspSuc()
    {
        die(Action::SUCCESS_KEY);
    }

    // fail
    protected function rspFail()
    {
        die(Action::FAIL_KEY);
    }
}