<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface as StoreScopeInterface;

/**
 * Interface ScopeInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ScopeInterface
{
    public const STORE_CONFIG_SCOPE_DEFAULT     = ScopeConfigInterface::SCOPE_TYPE_DEFAULT;
    public const STORE_CONFIG_SCOPE_STORES      = StoreScopeInterface::SCOPE_STORES;
    public const STORE_CONFIG_SCOPE_WEBSITES    = StoreScopeInterface::SCOPE_WEBSITES;
}
