<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\Config;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigTest extends TestCase
{
    use MockTrait;

    /**
     * @var Config|MockObject
     */
    protected $subject;

    /**
     * @var ScopeConfigInterface|MockObject
     */
    protected $scopeConfig;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->scopeConfig = $this->getMock(\Magento\Framework\App\Config::class, ['isSetFlag']);
        $this->objectManager = new ObjectManager($this);
        $this->subject = $this->objectManager->getObject(Config::class, ['scopeConfig' => $this->scopeConfig]);
    }

    public function testConfigShouldReturnFalse()
    {
        $this->scopeConfig->expects($this->any())
            ->method('isSetFlag')
            ->willReturn(false);
        $this->assertFalse($this->subject->isEnabled());
        $this->assertFalse($this->subject->isRecurringEnabled());
        $this->assertFalse($this->subject->isLoggerEnabled('fileLogger'));
        $this->assertFalse($this->subject->isLoggerEnabled('consoleLogger'));
        $this->assertFalse($this->subject->isFileLoggerEnabled());
        $this->assertFalse($this->subject->isConsoleLoggerEnabled());
    }

    public function testConfigShouldReturnTrue()
    {
        $this->scopeConfig->expects($this->any())
            ->method('isSetFlag')
            ->willReturn(true);
        $this->assertTrue($this->subject->isEnabled());
        $this->assertTrue($this->subject->isRecurringEnabled());
        $this->assertTrue($this->subject->isLoggerEnabled('fileLogger'));
        $this->assertTrue($this->subject->isLoggerEnabled('consoleLogger'));
        $this->assertTrue($this->subject->isFileLoggerEnabled());
        $this->assertTrue($this->subject->isConsoleLoggerEnabled());
    }
}
