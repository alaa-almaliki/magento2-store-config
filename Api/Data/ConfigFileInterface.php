<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Api\Data;

/**
 * Interface ConfigFileInterface
 *
 * @package Alaa\StoreConfig\Api\Data
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ConfigFileInterface
{
    const FILE_EXTENSION = 'php';

    public const CONFIG_ROOT = 'root';
    public const CONFIG_PATH = 'config_path';
    public const CONFIG_DEPLOY_MODE = 'deploy_mode';
    public const CONFIG_SCOPE = 'scope';
    public const CONFIG_CODE = 'code';

    /**
     * @return string
     */
    public function getRoot(): string;

    /**
     * @return string
     */
    public function getConfigPath(): string;

    /**
     * @return string
     */
    public function getDeployMode(): string;

    /**
     * @return string
     */
    public function getScope(): string;

    /**
     * @return string
     */
    public function getCode(): string;

    /**
     * @return string
     */
    public function getFile(): string;

    /**
     * @return array
     */
    public function getConfigurations(): array;
}
