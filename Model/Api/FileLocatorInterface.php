<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

/**
 * Interface FileLocatorInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface FileLocatorInterface
{
    /**
     * @param string $deployMode
     * @return array
     */
    public function locate(string $deployMode): array;
}
