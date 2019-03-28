<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\ConfigReader;
use Alaa\StoreConfig\Model\Configuration;
use Alaa\StoreConfig\Model\FileList;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Alaa\StoreConfig\Validators\FileExistsValidator;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigReaderTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigReaderTest extends TestCase
{
    use MockTrait;

    /**
     * @var ConfigReader
     */
    protected $subject;

    /**
     * @var FileList|MockObject
     */
    protected $fileList;

    /**
     * @var FileExistsValidator|MockObject
     */
    protected $fileExistsValidator;

    /**
     * @var Configuration|MockObject
     */
    protected $configuration;

    protected function setUp()
    {
        parent::setUp();
        $this->fileList = $this->getMock(FileList::class, ['getFiles']);
        $this->fileExistsValidator = $this->getMock(FileExistsValidator::class, ['validate']);
        $this->configuration = $this->getMock(Configuration::class, ['getConfigurationsByConfigFile']);

        $objectManager = new ObjectManager($this);
        $this->subject = $objectManager->getObject(ConfigReader::class, [
            'fileList' => $this->fileList,
            'fileExistsValidator' => $this->fileExistsValidator,
            'configuration' => $this->configuration
        ]);
    }

    public function testGetConfigurationsShouldReturnEmptyFilesArray()
    {
        $this->fileList->expects($this->any())
            ->method('getFiles')
            ->willReturn([]);

        $this->assertEmpty($this->subject->getConfigurations());
    }

    public function testGetConfigurationsShouldHaveNoFiles()
    {
        $this->fileList->expects($this->any())
            ->method('getFiles')
            ->willReturn([[]]);

        $this->assertEmpty($this->subject->getConfigurations());
    }

    public function testGetConfigurationsShouldReturnNotExistsFile()
    {
        $this->fileList->expects($this->any())
            ->method('getFiles')
            ->willReturn([[new ConfigFile(['file' => 'not/exist'])]]);

        $this->fileExistsValidator->expects($this->any())
            ->method('validate')
            ->willReturn(false);

        $this->assertEmpty($this->subject->getConfigurations());
    }

    public function testGetConfigurationsShouldReturnConfigurations()
    {
        $this->fileList->expects($this->any())
            ->method('getFiles')
            ->willReturn([[new ConfigFile(['file' => 'file/exist'])]]);

        $this->fileExistsValidator->expects($this->any())
            ->method('validate')
            ->willReturn(true);
        $configurations = [
            [
                'path' => 'xml/config/path',
                'value' => 1,
                'scope' => 'default',
                'scope_id' => 0
            ]
        ];

        $this->configuration->expects($this->any())
            ->method('getConfigurationsByConfigFile')
            ->willReturn($configurations);

        $expected = [
            $configurations
        ];

        $this->assertEquals($expected, $this->subject->getConfigurations());
    }
}
