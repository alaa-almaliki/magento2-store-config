<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\Config;
use Alaa\StoreConfig\Model\LoggerPool;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class LoggerPoolTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class LoggerPoolTest extends TestCase
{
    use MockTrait;

    /**
     * @var LoggerPool
     */
    protected $subject;

    /**
     * @var Config|MockObject
     */
    protected $config;

    protected function setUp()
    {
        parent::setUp();

        $objectManager = new ObjectManager($this);
        $this->config = $this->getMock(Config::class, ['isLoggerEnabled']);
        $logger = new class () {
            public function warning (string $msg)
            {

            }
        };

        $this->subject = $objectManager->getObject(LoggerPool::class, [
            'loggers' => [
                'fileLogger' => $logger,
                'consoleLogger' => $logger,
            ],
            'config' => $this->config
        ]);
    }

    public function testWarnHavingLoggersDisabled()
    {
        $this->config->expects($this->any())
            ->method('isLoggerEnabled')
            ->willReturn(false);

        $this->subject->warning('');
    }

    public function testWarnHavingConsoleLoggerDisabled()
    {
        $this->config->expects($this->at(0))
            ->method('isLoggerEnabled')
            ->with('fileLogger')
            ->willReturn(true);

        $this->config->expects($this->at(1))
            ->method('isLoggerEnabled')
            ->with('consoleLogger')
            ->willReturn(false);

        $this->subject->warning('');
    }

    public function testWarnHavingLoggersEnabled()
    {
        $this->config->expects($this->at(0))
            ->method('isLoggerEnabled')
            ->with('fileLogger')
            ->willReturn(true);

        $this->config->expects($this->at(1))
            ->method('isLoggerEnabled')
            ->with('consoleLogger')
            ->willReturn(true);

        $this->subject->warning('');
    }
}