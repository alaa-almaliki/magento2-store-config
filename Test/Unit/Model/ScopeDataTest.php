<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\CoreData;
use Alaa\StoreConfig\Model\ScopeData;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Alaa\StoreConfig\Validators\SensitivePathValidator;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class ScopeDataTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ScopeDataTest extends TestCase
{
    use MockTrait;

    /**
     * @var ScopeData
     */
    protected $subject;

    /**
     * @var CoreData|MockObject
     */
    protected $coreData;

    /**
     * @var SensitivePathValidator|MockObject
     */
    protected $sensitivePathValidator;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);

        $this->coreData = $this->getMock(CoreData::class, ['getData']);
        $this->sensitivePathValidator = $this->getMock(SensitivePathValidator::class, ['validate']);

        $this->subject = $objectManager->getObject(ScopeData::class, [
            'coreData' => $this->coreData,
            'sensitivePathValidator' => $this->sensitivePathValidator
        ]);
    }

    public function testGetScopeDataInvalidDefaultScope()
    {
        $this->coreData->expects($this->any())
            ->method('getData')
            ->willReturn([
                [
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/default',
                    'value' => '0'
                ],
                [
                    'scope' => 'websites',
                    'scope_id' => 1,
                    'path' => 'xml/path/websites',
                    'value' => '1'
                ],
                [
                    'scope' => 'stores',
                    'scope_id' => 2,
                    'path' => 'xml/path/stores',
                    'value' => '2'
                ],
            ]);

        $this->sensitivePathValidator->expects($this->at(0))
            ->method('validate')
            ->willReturn(false);
        $this->sensitivePathValidator->expects($this->at(1))
            ->method('validate')
            ->willReturn(true);
        $this->sensitivePathValidator->expects($this->at(2))
            ->method('validate')
            ->willReturn(true);

        $expectedResult = [
            'default' => [],
            'websites' => [
                [
                    'scope' => 'websites',
                    'scope_id' => 1,
                    'path' => 'xml/path/websites',
                    'value' => '1'
                ]
            ],
            'stores' => [
                [
                    'scope' => 'stores',
                    'scope_id' => 2,
                    'path' => 'xml/path/stores',
                    'value' => '2'
                ]
            ]
        ];

        $this->assertEquals($expectedResult, $this->subject->getScopeData());
    }

    public function testGetScopeDataInvalidWebsitesScope()
    {
        $this->coreData->expects($this->any())
            ->method('getData')
            ->willReturn([
                [
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/default',
                    'value' => '0'
                ],
                [
                    'scope' => 'websites',
                    'scope_id' => 1,
                    'path' => 'xml/path/websites',
                    'value' => '1'
                ],
                [
                    'scope' => 'stores',
                    'scope_id' => 2,
                    'path' => 'xml/path/stores',
                    'value' => '2'
                ],
            ]);

        $this->sensitivePathValidator->expects($this->at(0))
            ->method('validate')
            ->willReturn(true);
        $this->sensitivePathValidator->expects($this->at(1))
            ->method('validate')
            ->willReturn(false);
        $this->sensitivePathValidator->expects($this->at(2))
            ->method('validate')
            ->willReturn(true);

        $expectedResult = [
            'default' => [
                [
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/default',
                    'value' => '0'
                ]
            ],
            'websites' => [],
            'stores' => [
                [
                    'scope' => 'stores',
                    'scope_id' => 2,
                    'path' => 'xml/path/stores',
                    'value' => '2'
                ]
            ]
        ];

        $this->assertEquals($expectedResult, $this->subject->getScopeData());
    }

    public function testGetScopeDataInvalidStoresScope()
    {
        $this->coreData->expects($this->any())
            ->method('getData')
            ->willReturn([
                [
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/default',
                    'value' => '0'
                ],
                [
                    'scope' => 'websites',
                    'scope_id' => 1,
                    'path' => 'xml/path/websites',
                    'value' => '1'
                ],
                [
                    'scope' => 'stores',
                    'scope_id' => 2,
                    'path' => 'xml/path/stores',
                    'value' => '2'
                ],
            ]);

        $this->sensitivePathValidator->expects($this->at(0))
            ->method('validate')
            ->willReturn(true);
        $this->sensitivePathValidator->expects($this->at(1))
            ->method('validate')
            ->willReturn(true);
        $this->sensitivePathValidator->expects($this->at(2))
            ->method('validate')
            ->willReturn(false);

        $expectedResult = [
            'default' => [
                [
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/default',
                    'value' => '0'
                ]
            ],
            'websites' => [
                [
                    'scope' => 'websites',
                    'scope_id' => 1,
                    'path' => 'xml/path/websites',
                    'value' => '1'
                ]
            ],
            'stores' => [],
        ];

        $this->assertEquals($expectedResult, $this->subject->getScopeData());
    }

    public function testGetScopeDataShouldHaveValidScopes()
    {
        $this->coreData->expects($this->any())
            ->method('getData')
            ->willReturn([
                [
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/default',
                    'value' => '0'
                ],
                [
                    'scope' => 'websites',
                    'scope_id' => 1,
                    'path' => 'xml/path/websites',
                    'value' => '1'
                ],
                [
                    'scope' => 'stores',
                    'scope_id' => 2,
                    'path' => 'xml/path/stores',
                    'value' => '2'
                ],
            ]);

        $this->sensitivePathValidator->expects($this->any())
            ->method('validate')
            ->willReturn(true);

        $expectedResult = [
            'default' => [
                [
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/default',
                    'value' => '0'
                ]
            ],
            'websites' => [
                [
                    'scope' => 'websites',
                    'scope_id' => 1,
                    'path' => 'xml/path/websites',
                    'value' => '1'
                ]
            ],
            'stores' => [
                [
                    'scope' => 'stores',
                    'scope_id' => 2,
                    'path' => 'xml/path/stores',
                    'value' => '2'
                ]
            ],
        ];

        $this->assertEquals($expectedResult, $this->subject->getScopeData());
    }
}