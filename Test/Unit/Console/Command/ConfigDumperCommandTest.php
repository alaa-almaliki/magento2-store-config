<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Console\Command;

use Alaa\StoreConfig\Console\Command\ConfigDumperCommand;
use Alaa\StoreConfig\Model\ConfigDumper;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigDumperCommandTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigDumperCommandTest extends AbstractCommand
{
    use ConsoleMockTrait;

    /**
     * @var ConfigDumperCommand|MockObject
     */
    protected $subject;

    /**
     * @var ConfigDumper|MockObject
     */
    protected $configDumper;

    protected function setUp()
    {
        parent::setUp();
        $this->configDumper = $this->getMock(ConfigDumper::class, ['dump']);
        $this->subject = $this->objectManager->getObject(
            ConfigDumperCommand::class,
            ['config' => $this->config, 'configDumper' => $this->configDumper]
        );
    }

    public function testDumperShouldBeDisabled()
    {
        $this->config->expects($this->any())
            ->method('isEnabled')
            ->willReturn(false);
        $this->subject->run($this->getConsoleInputMock(), $this->getConsoleOutputMock());
    }

    public function testDumperShouldBeEnabled()
    {
        $this->config->expects($this->any())
            ->method('isEnabled')
            ->willReturn(true);
        $this->subject->run($this->getConsoleInputMock(), $this->getConsoleOutputMock());
    }
}