<?php
/**
 * author: crisen
 * email: crisen@crisen.org
 * date: 18-12-10
 * description:
 */

namespace Waimao\LaravelAi;


use Athlon18\AI\DriverFactory;
use http\Exception\InvalidArgumentException;
use Illuminate\Support\Arr;

class AiManager
{

    protected $app;
    protected $factory;
    protected $drivers;

    public function __construct($app, DriverFactory $factory)
    {
        $this->app = $app;
        $this->factory = $factory;
    }


    /**
     * @param string $name
     * @return mixed
     */
    public function driver($name = '')
    {
        $name = $name ?: $this->getDefaultDriver();

        $drivers = $this->app['config']['ai.drivers'];

        if (is_null($driver = Arr::get($drivers, $name))) {
            throw new InvalidArgumentException("Driver [{$name}] not configured");
        }

        return $this->makeDriver($name, $driver);
    }


    /**
     * @return mixed
     */
    protected function getDefaultDriver()
    {
        return $this->app['config']['ai.default'];
    }


    /**
     * @param $name
     * @param $config
     * @return mixed
     */
    protected function makeDriver($name, $config)
    {
        return $this->factory->make($name, $config);
    }
}
