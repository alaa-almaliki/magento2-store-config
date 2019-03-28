<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Alaa\StoreConfig\Model\Api\ConfigurationCheckerInterface;
use Alaa\StoreConfig\Model\Api\ConfigurationInterface;
use Alaa\StoreConfig\Model\Api\FileLocatorInterface;
use Alaa\StoreConfig\Validators\FileExistsValidator;
use Alaa\StoreConfig\Validators\SensitivePathValidator;

/**
 * Class ConfigurationChecker
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigurationChecker implements ConfigurationCheckerInterface
{
    /**
     * @var FileLocatorInterface
     */
    protected $fileLocator;

    /**
     * @var FileExistsValidator
     */
    protected $fileExistsValidator;

    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * @var SensitivePathValidator
     */
    protected $sensitivePathValidator;

    /**
     * ConfigReader constructor.
     *
     * @param FileLocatorInterface $fileLocator
     * @param ConfigurationInterface $configuration
     * @param FileExistsValidator $fileExistsValidator
     * @param SensitivePathValidator $sensitivePathValidator
     */
    public function __construct(
        FileLocatorInterface $fileLocator,
        ConfigurationInterface $configuration,
        FileExistsValidator $fileExistsValidator,
        SensitivePathValidator $sensitivePathValidator

    ) {
        $this->fileLocator = $fileLocator;
        $this->fileExistsValidator = $fileExistsValidator;
        $this->configuration = $configuration;
        $this->sensitivePathValidator = $sensitivePathValidator;
    }

    /**
     * @param string $deployMode
     * @return bool
     */
    public function checkMode(string $deployMode): bool
    {
        $locatedFiles = $this->fileLocator->locate($deployMode);
        if (empty($locatedFiles)) {
            return false;
        }

        $ok = true;
        foreach ($locatedFiles as $files) {
            foreach ($files as $file) {
                $ok &= $this->fileExistsValidator->validate($file->getFile()) &&
                    $this->getConfigurationStatus($file);

                /**
                 * break early if checks fail
                 */
                if (!$ok) {
                    return false;
                }
            }
        }

        return (bool) $ok;
    }

    /**
     * @param ConfigFileInterface $configFile
     * @return bool
     */
    protected function getConfigurationStatus(ConfigFileInterface $configFile): bool
    {
        $configurations = $configFile->getConfigurations();
        $configurationsByConfigFile = $this->configuration->getConfigurationsByConfigFile($configFile);
        return !empty($configurations) &&
            (count($configurations) === count($configurationsByConfigFile)) &&
            !$this->hasSensitiveData($configurationsByConfigFile);
    }

    /**
     * @param array $configurations
     * @return bool
     */
    protected function hasSensitiveData(array $configurations): bool
    {
        foreach ($configurations as $config) {
            if (!$this->sensitivePathValidator->validate($config)) {
                return true;
            }
        }

        return false;
    }
}
