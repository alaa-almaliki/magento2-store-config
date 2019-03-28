<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\Configuration;
use Alaa\StoreConfig\Model\LoggerPool;
use Alaa\StoreConfig\Model\Scopes;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Alaa\StoreConfig\Validators\RequiredArgumentsValidator;
use Alaa\StoreConfig\Validators\SensitivePathValidator;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigurationTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigurationTest extends TestCase
{
    use MockTrait;

    /**
     * @var Configuration
     */
    protected $subject;

    /**
     * @var Scopes|MockObject
     */
    protected $scopes;

    /**
     * @var RequiredArgumentsValidator|MockObject
     */
    protected $requiredArgumentsValidator;

    /**
     * @var SensitivePathValidator|MockObject
     */
    protected $sensitivePathValidator;

    /**
     * @var LoggerPool|MockObject
     */
    protected $loggerPool;

    /**
     * @var ConfigFile|MockObject
     */
    protected $configFile;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);

        $this->configFile = $this->getMock(ConfigFile::class, ['getConfigurations', 'getScope']);
        $this->scopes = $this->getMock(Scopes::class, ['getScopeId']);
        $this->requiredArgumentsValidator = $objectManager->getObject(RequiredArgumentsValidator::class, [
            'requiredArguments' => ['path', 'value']
        ]);
        $this->sensitivePathValidator = $this->getMock(SensitivePathValidator::class, ['validate']);
        $this->loggerPool = $this->getMock(LoggerPool::class, ['warning']);
        $this->subject = $objectManager->getObject(Configuration::class, [
            'scopes' => $this->scopes,
            'requiredArgumentsValidator' => $this->requiredArgumentsValidator,
            'sensitivePathValidator' => $this->sensitivePathValidator,
            'loggerPool' => $this->loggerPool
        ]);
    }

    public function testGetConfigurationsByConfigFileWithEmptyConfiguration()
    {
        $this->configFile->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([]);

        $this->assertEmpty($this->subject->getConfigurationsByConfigFile($this->configFile));
    }

    public function testGetConfigurationsByConfigFileMissingRequiredArguments()
    {
        $this->configFile->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([
                ['value' => 1]
            ]);

        $this->assertEmpty($this->subject->getConfigurationsByConfigFile($this->configFile));
    }

    public function testGetConfigurationsByConfigFileWithSensitiveConfigurations()
    {
        $this->doTestGetConfigurationsByConfigFile(true);
    }

    public function testGetConfigurationsByConfigFileWithoutSensitiveConfigurations()
    {
        $this->doTestGetConfigurationsByConfigFile(false);
    }

    private function doTestGetConfigurationsByConfigFile(bool $isSensitive)
    {
        $this->scopes->expects($this->any())
            ->method('getScopeId')
            ->willReturn(0);

        $this->configFile->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([
                ['path' => 'xml/path/1', 'value' => 1,]
            ]);

        $this->configFile->expects($this->any())
            ->method('getScope')
            ->willReturn('default');

        $this->sensitivePathValidator->expects($this->any())
            ->method('validate')
            ->willReturn($isSensitive);

        $expected = [
            [
                'path' => 'xml/path/1',
                'value' => 1,
                'scope' => 'default',
                'scope_id' => 0
            ]
        ];

        $this->assertTrue(is_array($this->subject->getConfigurationsByConfigFile($this->configFile)));
        $this->assertNotEmpty($this->subject->getConfigurationsByConfigFile($this->configFile));
        $this->assertEquals($expected, $this->subject->getConfigurationsByConfigFile($this->configFile));
    }
}
