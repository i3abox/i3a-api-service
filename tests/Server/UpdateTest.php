<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2018/6/26
 * Time: 10:01
 */
namespace OverNick\SimpleDemo\Test\Server;

use OverNick\SimpleDemo\Test\BaseTestCase;

class UpdateTest extends BaseTestCase
{

    protected $url = 'http://api.dh.test';

    /**
     * @test
     */
    public function push()
    {
        $zipUrl = "https://i3a-service.oss-cn-shenzhen.aliyuncs.com/uploads/2018-06-20-oSAuuhcy91xaeLDG.zip";

        $result = $this->getServer()->base->updated([
            'zip' => $zipUrl,
            'url' => $this->url,
            'key' => 'uSj7gaxGl3TCuHeXiWbWWi2yutM3R5Zm',
            'product' => 'i3a-product'
        ]);
        $this->assertEquals('Success', $result, 'Push Zip Fail');
    }

}