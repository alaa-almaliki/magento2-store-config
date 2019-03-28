<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;

/**
 * Interface ScopeConfigGeneratorInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ScopeConfigGeneratorInterface
{
    /**
     * @param ConfigFileInterface $configFile
     * @param array $scopeData
     * @return void
     */
    public function generate(ConfigFileInterface $configFile, array $scopeData);
}
