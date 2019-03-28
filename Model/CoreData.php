<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Magento\Framework\App\ResourceConnection;

/**
 * Class CoreData
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class CoreData
{
    public const TABLE_NAME = 'core_config_data';

    /**
     * @var ResourceConnection
     */
    protected $resourceConnection;

    /**
     * @var array
     */
    protected $coreData = [];

    /**
     * CoreData constructor.
     *
     * @param ResourceConnection $resourceConnection
     */
    public function __construct(ResourceConnection $resourceConnection)
    {
        $this->resourceConnection = $resourceConnection;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (empty($this->coreData)) {
            $connection = $this->resourceConnection->getConnection();
            $select = $connection->select()->from($this->getTableName());
            $this->coreData = $connection->fetchAssoc($select);
        }

        return $this->coreData;
    }

    /**
     * @return string
     */
    private function getTableName(): string
    {
        return $this->resourceConnection->getTableName(self::TABLE_NAME);
    }
}
