<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/25
 * Time: 11:07
 */

namespace OverNick\SimpleDemo\Test;

use OverNick\SimpleDemo\Client\App;

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
     * get Client
     *
     * @return \OverNick\SimpleDemo\Client\App
     */
    protected function getClient()
    {
        if(!$this->client instanceof App){
            $this->client = new App(require $this->file);
        }

        return $this->client;
    }
}