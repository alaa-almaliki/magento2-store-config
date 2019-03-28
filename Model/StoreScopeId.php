<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;

/**
 * Class StoreScopeId
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class StoreScopeId extends AbstractScopeId
{
    /**
     * @param ConfigFileInterface $configFile
     * @return string|int|null
     */
    public function getScopeId(ConfigFileInterface $configFile)
    {
        return $this->catchable->catch(function () use ($configFile) {
            return $this->storeManager->getStore($configFile->getCode())->getId();
        });
    }
}
