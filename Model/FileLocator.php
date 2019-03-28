<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Alaa\StoreConfig\Api\Data\ConfigFileInterfaceFactory;
use Alaa\StoreConfig\Model\Api\FileLocatorInterface;
use Alaa\StoreConfig\Model\Api\ScopeInterface;
use Magento\Framework\Filesystem\DirectoryList;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class FileLocator
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileLocator implements FileLocatorInterface, ScopeInterface
{
    public const STORE_CONFIG_PATH = 'app/etc/store-config';

    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var DirectoryList
     */
    protected $directoryList;

    /**
     * @var ConfigFileInterfaceFactory
     */
    protected $configFileFactory;

    /**
     * FileLocator constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param DirectoryList $directoryList
     * @param ConfigFileInterfaceFactory $configFileFactory
     */
    public function __construct(
        StoreManagerInterface $storeManager,
        DirectoryList $directoryList,
        ConfigFileInterfaceFactory $configFileFactory
    ) {
        $this->storeManager = $storeManager;
        $this->directoryList = $directoryList;
        $this->configFileFactory = $configFileFactory;
    }

    /**
     * @param string $deployMode
     * @return array
     */
    public function locate(string $deployMode): array
    {
        $root = $this->directoryList->getRoot();
        $defaultConfigFile = $this->getDefaultConfigFile($deployMode);
        $filePaths = [
            $defaultConfigFile->getScope() => [$defaultConfigFile]
        ];

        foreach ($this->getScopes() as $scope => $storeWebsites) {
            foreach ($storeWebsites as $storeWebsite) {
                $data = [
                    'root' => $root,
                    'config_path' => self::STORE_CONFIG_PATH,
                    'deploy_mode' => $deployMode,
                    'scope' => $scope,
                    'code' => $storeWebsite->getCode()
                ];

                $configFile = $this->configFileFactory->create(['data' => $data]);
                $filePaths[$configFile->getScope()][] = $configFile;
            }
        }

        return $filePaths;
    }

    /**
     * @param string $deployMode
     * @return ConfigFileInterface
     */
    protected function getDefaultConfigFile(string $deployMode): ConfigFileInterface
    {
        $filePath = [
            'root' => $this->directoryList->getRoot(),
            'config_path' => self::STORE_CONFIG_PATH,
            'deploy_mode' => $deployMode,
            'scope' => self::STORE_CONFIG_SCOPE_DEFAULT,
            'code' => self::STORE_CONFIG_SCOPE_DEFAULT
        ];

        return $this->configFileFactory->create(['data' => $filePath]);
    }

    /**
     * @return array
     */
    protected function getScopes(): array
    {
        return [
            self::STORE_CONFIG_SCOPE_STORES => $this->storeManager->getStores(),
            self::STORE_CONFIG_SCOPE_WEBSITES => $this->storeManager->getWebsites(),
        ];
    }
}
