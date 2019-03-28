<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Test\Unit\Model;

use Alaa\StoreConfig\Model\CoreData;
use Alaa\StoreConfig\Test\Unit\Util\MockTrait;
use Magento\Framework\App\ResourceConnection;
use Magento\Framework\DB\Adapter\Pdo\Mysql;
use Magento\Framework\DB\Select;
use Magento\Framework\TestFramework\Unit\Helper\ObjectManager;
use PHPUnit\Framework\TestCase;
use PHPUnit_Framework_MockObject_MockObject as MockObject;

/**
 * Class CoreDataTest
 *
 * @package Alaa\StoreConfig\Test\Unit\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class CoreDataTest extends TestCase
{
    use MockTrait;

    /**
     * @var CoreData
     */
    protected $subject;

    /**
     * @var ResourceConnection|MockObject
     */
    protected $resourceConnection;

    /**
     * @var Mysql|MockObject
     */
    protected $connection;

    /**
     * @var Select|MockObject
     */
    protected $select;

    protected function setUp()
    {
        parent::setUp();
        $objectManager = new ObjectManager($this);

        $this->select = $this->getMock(Select::class, ['from']);
        $this->connection = $this->getMock(Mysql::class, ['select', 'fetchAssoc']);
        $this->connection->expects($this->any())
            ->method('select')
            ->willReturn($this->select);

        $this->resourceConnection = $this->getMock(
            ResourceConnection::class,
            [
                'getConnection',
                'getTableName'
            ]
        );

        $this->resourceConnection->expects($this->any())
            ->method('getConnection')
            ->willReturn($this->connection);

        $this->resourceConnection->expects($this->any())
            ->method('getTableName')
            ->willReturn(CoreData::TABLE_NAME);

        $this->subject = $objectManager->getObject(CoreData::class, [
            'resourceConnection' => $this->resourceConnection
        ]);
    }

    public function testGetDataShouldReturnEmptyResults()
    {
        $this->connection->expects($this->any())
            ->method('fetchAssoc')
            ->willReturn([]);

        $this->assertEmpty($this->subject->getData());
        $this->assertEmpty($this->subject->getData());
    }

    public function testGetDataShouldReturnReuslt()
    {
        $this->connection->expects($this->any())
            ->method('fetchAssoc')
            ->willReturn([
                [
                    'config_id' => 1,
                    'scope' => 'default',
                    'scope_id' => 0,
                    'path' => 'xml/path/1',
                    'value' => 1,
                ]
            ]);

        $this->assertNotEmpty($this->subject->getData());
    }
}
