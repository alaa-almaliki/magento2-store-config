<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Model\Api\ConfigReaderInterface;
use Alaa\StoreConfig\Model\Api\ConfigurationInterface;
use Alaa\StoreConfig\Model\Api\FileListInterface;
use Alaa\StoreConfig\Validators\FileExistsValidator;

/**
 * Class ConfigReader
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigReader implements ConfigReaderInterface
{
    /**
     * @var FileListInterface
     */
    protected $fileList;

    /**
     * @var FileExistsValidator
     */
    protected $fileExistsValidator;

    /**
     * @var ConfigurationInterface
     */
    protected $configuration;

    /**
     * ConfigReader constructor.
     *
     * @param FileListInterface $fileList
     * @param FileExistsValidator $fileExistsValidator
     * @param ConfigurationInterface $configuration
     */
    public function __construct(
        FileListInterface $fileList,
        FileExistsValidator $fileExistsValidator,
        ConfigurationInterface $configuration
    ) {
        $this->fileList = $fileList;
        $this->fileExistsValidator = $fileExistsValidator;
        $this->configuration = $configuration;
    }

    /**
     * @return array
     */
    public function getConfigurations(): array
    {
        $configurations = [];
        foreach ($this->fileList->getFiles() as $files) {
            foreach ($files as $file) {
                if ($this->fileExistsValidator->validate($file->getFile())) {
                    $configurations[] = $this->configuration->getConfigurationsByConfigFile($file);
                }
            }
        }

        return $configurations;
    }
}
