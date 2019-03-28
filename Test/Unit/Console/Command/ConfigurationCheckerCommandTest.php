<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Console\Command;

use Alaa\StoreConfig\Console\Command\ConfigurationCheckerCommand;
use Alaa\StoreConfig\Model\Catchable;
use Alaa\StoreConfig\Model\ConfigurationChecker;
use Alaa\StoreConfig\Model\DeployMode;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Style\SymfonyStyleFactory;

/**
 * Class ConfigurationCheckerCommandTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigurationCheckerCommandTest extends AbstractCommand
{
    /**
     * @var ConfigurationCheckerCommand|MockObject
     */
    protected $subject;

    /**
     * @var MockObject|ConfigurationChecker
     */
    protected $configurationChecker;

    /**
     * @var DeployMode|MockObject
     */
    protected $deployMode;

    /**
     * @var SymfonyStyle|MockObject
     */
    protected $symfonyStyle;

    protected function setUp()
    {
        parent::setUp();
        $this->configurationChecker = $this->getMock(ConfigurationChecker::class, ['checkMode']);
        $this->deployMode = $this->objectManager->getObject(
            DeployMode::class,
            ['catchable' => $this->objectManager->getObject(Catchable::class)]
        );
        $this->symfonyStyle = $this->getMock(SymfonyStyle::class, ['warning', 'success']);
        $symfonyStyleFactory = $this->getMock(SymfonyStyleFactory::class, ['create']);

        $symfonyStyleFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->symfonyStyle);

        $this->subject = $this->objectManager->getObject(ConfigurationCheckerCommand::class, [
            'config' => $this->config,
            'configurationChecker' => $this->configurationChecker,
            'deployMode' => $this->deployMode,
            'symfonyStyleFactory' => $symfonyStyleFactory
        ]);
    }

    public function testRunShouldBeDisabled()
    {
        $this->config->expects($this->any())
            ->method('isEnabled')
            ->willReturn(false);
        $this->subject->run($this->getConsoleInputMock(), $this->getConsoleOutputMock());
    }

    public function testConfigurationCheckerShouldFail()
    {
        $this->config->expects($this->any())
            ->method('isEnabled')
            ->willReturn(true);
        $this->configurationChecker->expects($this->any())
            ->method('checkMode')
            ->willReturn(false);
        $this->subject->run($this->getConsoleInputMock(), $this->getConsoleOutputMock());
    }

    public function testConfigurationCheckerShouldPass()
    {
        $this->config->expects($this->any())
            ->method('isEnabled')
            ->willReturn(true);
        $this->configurationChecker->expects($this->any())
            ->method('checkMode')
            ->willReturn(true);
        $this->subject->run($this->getConsoleInputMock(), $this->getConsoleOutputMock());
    }
}
