<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;

/**
 * Interface ConfigurationInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ConfigurationInterface
{
    /**
     * @param ConfigFileInterface $configFile
     * @return array
     */
    public function getConfigurationsByConfigFile(ConfigFileInterface $configFile): array;
}
