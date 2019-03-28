<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

namespace Alaa\StoreConfig\Test\Unit\Util;

use Alaa\StoreConfig\Model\Config;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Trait MockTrait
 *
 * @package Alaa\StoreConfig\Test\Unit
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
trait MockTrait
{
    /**
     * @param string $class
     * @param array|null $methods
     * @param array|null $constructorArgs
     * @return mixed
     */
    public function getMock(string $class, array $methods = null, array $constructorArgs = null)
    {
        $builder = $this->getMockBuilder($class);
        if (null !== $constructorArgs) {
            $builder->setConstructorArgs($constructorArgs);
        } else {
            $builder->disableOriginalConstructor();
        }

        $builder->setMethods($methods);
        return $builder->getMock();
    }

    /**
     * @return MockObject|Config
     */
    protected function getConfigMock()
    {
        return $this->getMock(Config::class, ['isEnabled', 'isRecurringEnabled']);
    }
}