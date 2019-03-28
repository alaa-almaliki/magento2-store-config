<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Console\Command;

use Alaa\StoreConfig\Console\Command\ConfigurationWriterCommand;
use Alaa\StoreConfig\Model\ConfigWriter;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigurationWriterCommandTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigurationWriterCommandTest extends AbstractCommand
{
    /**
     * @var ConfigurationWriterCommand
     */
    protected $subject;

    /**
     * @var ConfigWriter|MockObject
     */
    protected $configWriter;

    protected function setUp()
    {
        parent::setUp();
        $this->configWriter = $this->getMock(ConfigWriter::class, ['configure']);
        $this->subject = $this->objectManager->getObject(
            ConfigurationWriterCommand::class,
            ['config' => $this->config, 'configWriter' => $this->configWriter]
        );
    }

    public function testRunShouldBeDisabled()
    {
        $this->config->expects($this->any())
            ->method('isEnabled')
            ->willReturn(false);
        $this->subject->run($this->getConsoleInputMock(), $this->getConsoleOutputMock());
    }

    public function testRunShouldBeEnabled()
    {
        $this->config->expects($this->any())
            ->method('isEnabled')
            ->willReturn(true);
        $this->subject->run($this->getConsoleInputMock(), $this->getConsoleOutputMock());
    }
}
