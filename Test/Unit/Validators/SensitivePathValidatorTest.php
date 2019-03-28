<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Validators;

use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Alaa\StoreConfig\Validators\SensitivePathValidator;
use Magento\Config\Model\Config\TypePool;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class SensitivePathValidatorTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class SensitivePathValidatorTest extends TestCase
{
    use MockTrait;

    /**
     * @var SensitivePathValidator
     */
    protected $subject;

    /**
     * @var TypePool|MockObject
     */
    protected $typePool;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);
        $this->typePool = $this->getMock(TypePool::class, ['isPresent']);
        $this->subject = $objectManager->getObject(SensitivePathValidator::class, [
            'typePool' => $this->typePool
        ]);
    }

    public function testValidateShouldReturnTrue()
    {
        $this->typePool->expects($this->any())
            ->method('isPresent')
            ->willReturn(false);
        $this->assertTrue($this->subject->validate(['path' => 'xml/path/1', 'value' => 1]));
    }

    public function testValidateShouldReturnFalse()
    {
        $this->typePool->expects($this->any())
            ->method('isPresent')
            ->willReturn(true);
        $this->assertFalse($this->subject->validate(['path' => 'xml/path/1', 'value' => 1]));
    }
}
