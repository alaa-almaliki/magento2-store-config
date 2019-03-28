<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\ConfigFile;
use Alaa\StoreConfig\Model\ScopeConfigGenerator;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\Filesystem\Io\File;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;
use Zend\Code\Generator\ValueGenerator;
use Zend\Code\Generator\ValueGeneratorFactory;

/**
 * Class ScopeConfigGeneratorTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ScopeConfigGeneratorTest extends TestCase
{
    use MockTrait;

    /**
     * @var ScopeConfigGenerator
     */
    protected $subject;

    /**
     * @var File|MockObject
     */
    protected $fileAdapter;

    /**
     * @var ValueGeneratorFactory|MockObject
     */
    protected $valueGeneratorFactory;

    /**
     * @var ValueGenerator|MockObject
     */
    protected $valueGenerator;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);

        $this->fileAdapter = $this->getMock(File::class, ['mkdir', 'write', 'chmod']);
        $this->valueGeneratorFactory = $this->getMock(ValueGeneratorFactory::class, ['create']);
        $this->valueGenerator = $this->getMock(ValueGenerator::class, ['generate']);
        $this->valueGeneratorFactory->expects($this->any())
            ->method('create')
            ->willReturn($this->valueGenerator);

        $this->subject = $objectManager->getObject(ScopeConfigGenerator::class, [
            'fileAdapter' => $this->fileAdapter,
            'valueGeneratorFactory' => $this->valueGeneratorFactory
        ]);
    }

    public function testGenerate()
    {
        $this->subject->generate(new ConfigFile(), [
            ['path' => 'xml/path/1', 'value' => '1']
        ]);
    }
}
