<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Magento\Framework\DataObject;

/**
 * Class ConfigFile
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigFile extends DataObject implements ConfigFileInterface
{
    /**
     * @return string
     */
    public function getRoot(): string
    {
        return $this->_getData(self::CONFIG_ROOT);
    }

    /**
     * @return string
     */
    public function getConfigPath(): string
    {
        return $this->_getData(self::CONFIG_PATH);
    }

    /**
     * @return string
     */
    public function getDeployMode(): string
    {
        return $this->_getData(self::CONFIG_DEPLOY_MODE);
    }

    /**
     * @return string
     */
    public function getScope(): string
    {
        return $this->_getData(self::CONFIG_SCOPE);
    }

    /**
     * @return string
     */
    public function getCode(): string
    {
        return $this->_getData(self::CONFIG_CODE);
    }

    /**
     * @return string
     */
    public function getFile(): string
    {
        return \implode(DIRECTORY_SEPARATOR, $this->getData()) . '.' . self::FILE_EXTENSION;
    }

    /**
     * @return array
     */
    public function getConfigurations(): array
    {
        return include $this->getFile();
    }
}
