<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\FileList;
use Alaa\StoreConfig\Model\FileLocator;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Alaa\StoreConfig\Validators\DeployModeValidator;
use Magento\Framework\App\State;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class FileListTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileListTest extends TestCase
{
    use MockTrait;

    /**
     * @var FileList
     */
    protected $subject;

    /**
     * @var State|MockObject
     */
    protected $appState;

    /**
     * @var FileLocator|MockObject
     */
    protected $fileLocator;

    /**
     * @var DeployModeValidator|MockObject
     */
    protected $deployModeValidator;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);

        $this->appState = $this->getMock(State::class, ['getMode']);
        $this->fileLocator = $this->getMock(FileLocator::class, ['locate']);
        $this->deployModeValidator = new DeployModeValidator();

        $this->subject = $objectManager->getObject(FileList::class, [
            'appState' => $this->appState,
            'fileLocator' => $this->fileLocator,
            'deployModeValidator' => $this->deployModeValidator
        ]);
    }

    public function testGetFilesShouldHaveInvalidDeployMode()
    {
        $this->appState->expects($this->any())
            ->method('getMode')
            ->willReturn('default');

        $this->assertEmpty($this->subject->getFiles());
    }

    public function testGetFilesShouldHaveValidDeployMode()
    {
        $this->appState->expects($this->any())
            ->method('getMode')
            ->willReturn('developer');

        $this->fileLocator->expects($this->any())
            ->method('locate')
            ->willReturn([[[new ConfigFile()]]]);

        $this->assertNotEmpty($this->subject->getFiles());
    }
}