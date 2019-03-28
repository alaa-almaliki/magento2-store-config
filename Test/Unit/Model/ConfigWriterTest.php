<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigReader;
use Alaa\StoreConfig\Model\ConfigWriter;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\App\Config\Storage\Writer;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ConfigWriterTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigWriterTest extends TestCase
{
    use MockTrait;

    /**
     * @var ConfigWriter
     */
    protected $subject;

    /**
     * @var ConfigReader|MockObject
     */
    protected $configReader;

    /**
     * @var Writer|MockObject
     */
    protected $writer;

    protected function setUp()
    {
        parent::setUp();

        $this->configReader = $this->getMock(ConfigReader::class, ['getConfigurations']);
        $this->writer = $this->getMock(Writer::class, ['save']);
        $objectManager = new ObjectManager($this);
        $this->subject = $objectManager->getObject(ConfigWriter::class, [
            'configReader' => $this->configReader,
            'dbConfigWriter' => $this->writer
        ]);
    }

    public function testConfigureShouldReturnEmptyConfigurations()
    {
        $this->configReader->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([[]]);

        $this->subject->configure();
    }

    public function testConfigureShouldReturnValidConfigurations()
    {
        $this->configReader->expects($this->any())
            ->method('getConfigurations')
            ->willReturn([
                [[
                    'path' => 'xml/path/1',
                    'value' => '1',
                    'scope' => 'default',
                    'scope_id' => 0
                ],
                [
                    'path' => 'xml/path/2',
                    'value' => '2',
                    'scope' => 'default',
                    'scope_id' => 0
                ]],
            ]);

        $this->subject->configure();
    }
}
