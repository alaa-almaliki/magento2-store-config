<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

/**
 * Interface ConfigurationCheckerInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ConfigurationCheckerInterface
{
    /**
     * @param string $deployMode
     * @return bool
     */
    public function checkMode(string $deployMode): bool;
}
