<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Setup;

use Alaa\StoreConfig\Model\Config;
use Alaa\StoreConfig\Model\ConfigWriter;
use Alaa\StoreConfig\Setup\Recurring;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Setup\Model\ModuleContext;
use Magento\Setup\Module\Setup;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class RecurringTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Setup
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class RecurringTest extends TestCase
{
    use MockTrait;

    /**
     * @var Recurring
     */
    protected $subject;

    /**
     * @var Config|MockObject
     */
    protected $config;

    /**
     * @var ConfigWriter|MockObject
     */
    protected $configWriter;

    /**
     * @var Setup|MockObject
     */
    protected $setup;

    /**
     * @var ModuleContext|MockObject
     */
    protected $moduleContext;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);
        $this->config = $this->getConfigMock();
        $this->configWriter = $this->getMock(ConfigWriter::class, ['configure']);
        $this->subject = $objectManager->getObject(Recurring::class, [
            'configWriter' => $this->configWriter,
            'config' => $this->config
        ]);

        $this->setup = $this->getMock(Setup::class);
        $this->moduleContext = $this->getMock(ModuleContext::class);
    }

    public function testInstallShouldBeDisabled()
    {
        $this->config->expects($this->any())
            ->method('isRecurringEnabled')
            ->willReturn(false);
        $this->subject->install($this->setup, $this->moduleContext);
    }

    public function testInstallShouldBeEnabled()
    {
        $this->config->expects($this->any())
            ->method('isRecurringEnabled')
            ->willReturn(true);
        $this->subject->install($this->setup, $this->moduleContext);
    }
}