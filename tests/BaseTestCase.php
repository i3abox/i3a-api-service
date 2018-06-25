<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/25
 * Time: 11:07
 */

/**
 * Class BaseTestCase
 */
class BaseTestCase extends \PHPUnit\Framework\TestCase
{
    protected $server;

    protected $client;

    protected $test_url = 'http://dh.jc.test';

    protected $file = __DIR__.'/../tests/simple-auth.php';

    /**
     * @return \OverNick\Auth\Server\App
     */
    protected function getServer()
    {
        if (!$this->client instanceof \OverNick\Auth\Server\App){
            $this->client = new \OverNick\Auth\Server\App(require $this->file);
        }

        return $this->client;
    }

    /**
     * get Client
     *
     * @return \OverNick\Auth\Client\App
     */
    protected function getClient()
    {
        if(!$this->client instanceof \OverNick\Auth\Client\App){
            $this->client = new \OverNick\Auth\Client\App(require $this->file);
        }

        return $this->client;
    }
}