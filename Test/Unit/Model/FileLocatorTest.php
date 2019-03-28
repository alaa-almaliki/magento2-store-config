<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterfaceFactory;
use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\FileLocator;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\DataObject;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Store\Model\StoreManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class FileLocatorTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileLocatorTest extends TestCase
{
    use MockTrait;

    /**
     * @var FileLocator
     */
    protected $subject;

    /**
     * @var StoreManager|MockObject
     */
    protected $storeManager;

    /**
     * @var DirectoryList|MockObject
     */
    protected $directoryList;

    /**
     * @var ConfigFileInterfaceFactory|MockObject
     */
    protected $configFileFactory;

    /**
     * @var ConfigFile|MockObject
     */
    protected $configFile;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);

        $this->storeManager = $this->getMock(StoreManager::class, ['getStores', 'getWebsites']);
        $this->directoryList = $this->getMock(DirectoryList::class, ['getRoot']);
        $this->configFileFactory = $this->getMock(ConfigFileInterfaceFactory::class, ['create']);
        $this->configFile = $this->getMock(ConfigFile::class, ['getScope']);

        $this->configFileFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->configFile);

        $this->subject = $objectManager->getObject(FileLocator::class, [
            'storeManager' => $this->storeManager,
            'directoryList' => $this->directoryList,
            'configFileFactory' => $this->configFileFactory
        ]);
    }

    public function testLocate()
    {
        $this->directoryList->expects($this->any())
            ->method('getRoot')
            ->willReturn('/www/html');

        $this->storeManager->expects($this->any())
            ->method('getStores')
            ->willReturn([
                new DataObject(['id' => 1, 'code' => 'default'])
            ]);
        $this->storeManager->expects($this->any())
            ->method('getWebsites')
            ->willReturn([
                new DataObject(['id' => 1, 'code' => 'base'])
            ]);

        $this->configFile->expects($this->at(0))
            ->method('getScope')
            ->willReturn('default');
        $this->configFile->expects($this->at(1))
            ->method('getScope')
            ->willReturn('stores');
        $this->configFile->expects($this->at(2))
            ->method('getScope')
            ->willReturn('websites');

        $result = $this->subject->locate('');
        $this->assertArrayHasKey('default', $result);
        $this->assertArrayHasKey('stores', $result);
        $this->assertArrayHasKey('websites', $result);
    }
}
