<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\Catchable;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use Magento\Store\Model\StoreManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class AbstractScopeId
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractScopeId extends TestCase
{
    use MockTrait;

    /**
     * @var StoreManager|MockObject
     */
    protected $storeManager;

    /**
     * @var Catchable
     */
    protected $catchable;

    /**
     * @var ObjectManager
     */
    protected $objectManager;

    protected function setUp()
    {
        parent::setUp();
        $this->objectManager = new ObjectManager($this);

        $storeMock = new class() {
            public function getId(): int
            {
                return 1;
            }
        };
        $this->storeManager = $this->getMock(StoreManager::class, ['getStore', 'getWebsite']);
        $this->catchable = new Catchable();

        $this->storeManager->expects($this->any())
            ->method('getStore')
            ->willReturn($storeMock);
        $this->storeManager->expects($this->any())
            ->method('getWebsite')
            ->willReturn($storeMock);
    }
}