<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigDumper;
use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\FileList;
use Alaa\StoreConfig\Model\ScopeConfigGenerator;
use Alaa\StoreConfig\Model\ScopeData;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigDumperTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigDumperTest extends TestCase
{
    use MockTrait;

    /**
     * @var ConfigDumper
     */
    protected $subject;

    /**
     * @var ScopeData|MockObject
     */
    protected $scopeData;

    /**
     * @var ScopeConfigGenerator|MockObject
     */
    protected $scopeConfigGenerator;

    /**
     * @var FileList|MockObject
     */
    protected $fileList;

    /**
     * @var ConfigFile
     */
    protected $configFile;

    protected function setUp()
    {
        parent::setUp();
        $this->scopeData = $this->getMock(ScopeData::class, ['getScopeData']);
        $this->scopeConfigGenerator = $this->getMock(ScopeConfigGenerator::class, ['generate']);
        $this->fileList = $this->getMock(FileList::class, ['getFiles']);
        $objectManager = new ObjectManager($this);
        $this->configFile = $objectManager->getObject(ConfigFile::class);
        $this->subject = $objectManager->getObject(ConfigDumper::class, [
            'scopeData' => $this->scopeData,
            'scopeConfigGenerator' => $this->scopeConfigGenerator,
            'fileList' => $this->fileList
        ]);
    }

    public function testDumpShouldHaveEmptyFiles()
    {
        $this->fileList->expects($this->any())
            ->method('getFiles')
            ->willReturn([]);
        $this->subject->dump();
    }

    public function testDumpShouldHaveNoScope()
    {
        $this->fileList->expects($this->any())
            ->method('getFiles')
            ->willReturn([
                [$this->configFile],
            ]);
        $this->subject->dump();
    }

    public function testDumpShouldHaveScope()
    {
        $this->scopeData->expects($this->any())
            ->method('getScopeData')
            ->willReturn([
                'default' => ['scope' => 'stores', 'scope_id' => 0, 'path' => 'my/dummy/path', 'value' => 1],
                'websites' => [],
                'stores' => [],
            ]);
        $this->fileList->expects($this->any())
            ->method('getFiles')
            ->willReturn([
                'default' => [$this->configFile],
                'websites' => [$this->configFile],
                'stores' => [$this->configFile],
            ]);
        $this->subject->dump();
    }
}