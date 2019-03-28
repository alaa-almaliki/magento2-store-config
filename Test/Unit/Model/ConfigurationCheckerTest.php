<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\Configuration;
use Alaa\StoreConfig\Model\ConfigurationChecker;
use Alaa\StoreConfig\Model\FileLocator;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Alaa\StoreConfig\Validators\FileExistsValidator;
use Alaa\StoreConfig\Validators\SensitivePathValidator;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigurationCheckerTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigurationCheckerTest extends TestCase
{
    use MockTrait;

    /**
     * @var ConfigurationChecker
     */
    protected $subject;

    /**
     * @var FileLocator|MockObject
     */
    protected $fileLocator;

    /**
     * @var Configuration|MockObject
     */
    protected $configuration;

    /**
     * @var FileExistsValidator|MockObject
     */
    protected $fileExistsValidator;

    /**
     * @var SensitivePathValidator|MockObject
     */
    protected $sensitivePathValidator;

    /**
     * @var ConfigFile|MockObject
     */
    protected $configFile;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);

        $this->configFile = $this->getMock(ConfigFile::class, ['getConfigurations']);
        $this->fileLocator = $this->getMock(FileLocator::class, ['locate']);
        $this->configuration = $this->getMock(Configuration::class, ['getConfigurationsByConfigFile']);
        $this->fileExistsValidator = $this->getMock(FileExistsValidator::class, ['validate']);
        $this->sensitivePathValidator = $this->getMock(SensitivePathValidator::class, ['validate']);
        $this->subject = $objectManager->getObject(ConfigurationChecker::class, [
            'fileLocator' => $this->fileLocator,
            'configuration' => $this->configuration,
            'fileExistsValidator' => $this->fileExistsValidator,
            'sensitivePathValidator' => $this->sensitivePathValidator
        ]);
    }

    public function testCheckModeWithLocatorShouldReturnEmptyFiles()
    {
        $this->fileLocator->expects($this->any())
            ->method('locate')
            ->willReturn([]);

        $this->assertFalse($this->subject->checkMode('developer'));
    }

    public function testCheckModeConfigFileShouldNotExists()
    {
        $this->fileLocator->expects($this->any())
            ->method('locate')
            ->willReturn([[$this->configFile]]);

        $this->fileExistsValidator->expects($this->any())
            ->method('validate')
            ->willReturn(false);

        $this->assertTrue($this->subject->checkMode('developer'));
    }

    public function testCheckModeShouldHaveEmptyConfigurations()
    {
        $this->configFile->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([[]]);

        $this->configuration->expects($this->any())
            ->method('getConfigurationsByConfigFile')
            ->willReturn([[]]);

        $this->fileLocator->expects($this->any())
            ->method('locate')
            ->willReturn([[$this->configFile]]);

        $this->fileExistsValidator->expects($this->any())
            ->method('validate')
            ->willReturn(true);

        $this->assertFalse($this->subject->checkMode('developer'));
    }

    public function testCheckModeShouldHaveDifferentConfigurationsCount()
    {
        $this->configFile->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([['path' => 'xml/path/1','value' => 1]]);

        $this->configuration->expects($this->any())
            ->method('getConfigurationsByConfigFile')
            ->willReturn([['path' => 'xml/path/1','value' => 1], ['path' => 'xml/path/2','value' => 2]]);

        $this->fileLocator->expects($this->any())
            ->method('locate')
            ->willReturn([[$this->configFile]]);

        $this->fileExistsValidator->expects($this->any())
            ->method('validate')
            ->willReturn(true);

        $this->assertFalse($this->subject->checkMode('developer'));
    }

    public function testCheckModeShouldHaveSensitiveConfigurations()
    {
        $this->configFile->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([['path' => 'xml/path/1','value' => 1], ['path' => 'xml/path/2','value' => 2]]);

        $this->configuration->expects($this->any())
            ->method('getConfigurationsByConfigFile')
            ->willReturn([['path' => 'xml/path/1','value' => 1], ['path' => 'xml/path/2','value' => 2]]);

        $this->fileLocator->expects($this->any())
            ->method('locate')
            ->willReturn([[$this->configFile]]);

        $this->fileExistsValidator->expects($this->any())
            ->method('validate')
            ->willReturn(true);

        $this->sensitivePathValidator->expects($this->any())
            ->method('validate')
            ->willReturn(false);

        $this->assertFalse($this->subject->checkMode('developer'));
    }

    public function testCheckModeShouldReturnTrue()
    {
        $this->configFile->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([['path' => 'xml/path/1','value' => 1], ['path' => 'xml/path/2','value' => 2]]);

        $this->configuration->expects($this->any())
            ->method('getConfigurationsByConfigFile')
            ->willReturn([['path' => 'xml/path/1','value' => 1], ['path' => 'xml/path/2','value' => 2]]);

        $this->fileLocator->expects($this->any())
            ->method('locate')
            ->willReturn([[$this->configFile]]);

        $this->fileExistsValidator->expects($this->any())
            ->method('validate')
            ->willReturn(true);

        $this->sensitivePathValidator->expects($this->any())
            ->method('validate')
            ->willReturn(true);

        $this->assertTrue($this->subject->checkMode('developer'));
    }
}
