<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Magento\Store\Model\Store;

/**
 * Class Scopes
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Scopes
{
    public const DEFAULT_STORE_ID = Store::DEFAULT_STORE_ID;

    /**
     * @var AbstractScopeId[]|array
     */
    protected $scopeIds;

    /**
     * Scopes constructor.
     *
     * @param AbstractScopeId[]|array $scopeIds
     */
    public function __construct(array $scopeIds)
    {
        $this->scopeIds = $scopeIds;
    }

    /**
     * @param ConfigFileInterface $configFile
     * @return int|string|null
     */
    public function getScopeId(ConfigFileInterface $configFile)
    {
        if ($configFile->getScope() === FileLocator::STORE_CONFIG_SCOPE_DEFAULT) {
            return self::DEFAULT_STORE_ID;
        }

        return $this->scopeIds[$configFile->getScope()]->getScopeId($configFile);
    }
}
