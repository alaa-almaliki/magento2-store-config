<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;

/**
 * Interface FileListInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface FileListInterface
{
    /**
     * @return ConfigFileInterface[]|array
     */
    public function getFiles(): array;
}
