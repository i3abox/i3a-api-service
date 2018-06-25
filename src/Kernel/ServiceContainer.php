<?php
namespace OverNick\SimpleDemo\Kernel;

use OverNick\Support\Config;
use Pimple\Container;

/**
 * Class ServiceContainer.
 *
 * @property \OverNick\Support\Config $config
 *
 * @author overnic <i@httpd.cc>
 *
 */
class ServiceContainer extends Container
{
    /**
     * @var array
     */
    protected $providers = [];

    /**
     * Constructor.
     *
     * @param array       $config
     * @param array       $prepends
     */
    public function __construct(array $config = [],array $prepends = [])
    {
        parent::__construct($prepends);

        $this->offsetSet('config', new Config($config));

        $this->registerProviders($this->providers);
    }

    /**
     * Magic get access.
     *
     * @param string $id
     *
     * @return mixed
     */
    public function __get($id)
    {
        return $this->offsetGet($id);
    }

    /**
     * Magic set access.
     *
     * @param string $id
     * @param mixed  $value
     */
    public function __set($id, $value)
    {
        $this->offsetSet($id, $value);
    }

    /**
     * @param array $providers
     */
    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }
}
