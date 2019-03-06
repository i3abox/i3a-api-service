<?php
/**
 * Created by PhpStorm.
 * User: overnic
 * Date: 2019/3/6
 * Time: 10:04
 */
namespace I3A\Api\Client\Crypt;

use I3A\Api\Kernel\Abstracts\BaseClient;
use I3A\Api\Kernel\Traits\AppCryptTrait;

/**
 * 加密组件
 *
 * Class Client
 * @package I3A\Api\Client\Crypt
 */
class Client extends BaseClient
{
    use AppCryptTrait;
}