<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Model\Api\ConfigDumperInterface;
use Alaa\StoreConfig\Model\Api\FileListInterface;
use Alaa\StoreConfig\Model\Api\ScopeConfigGeneratorInterface;

/**
 * Class ConfigDumper
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigDumper implements ConfigDumperInterface
{
    /**
     * @var ScopeData
     */
    protected $scopeData;

    /**
     * @var ScopeConfigGeneratorInterface
     */
    protected $scopeConfigGenerator;

    /**
     * @var FileListInterface
     */
    protected $fileList;

    /**
     * CoreDataWriter constructor.
     *
     * @param ScopeData $scopeData
     * @param ScopeConfigGeneratorInterface $scopeConfigGenerator
     * @param FileListInterface $fileList
     */
    public function __construct(
        ScopeData $scopeData,
        ScopeConfigGeneratorInterface $scopeConfigGenerator,
        FileListInterface $fileList
    ) {
        $this->scopeData = $scopeData;
        $this->scopeConfigGenerator = $scopeConfigGenerator;
        $this->fileList = $fileList;
    }

    /**
     * @inheritdoc
     */
    public function dump()
    {
        $scopeData = $this->scopeData->getScopeData();
        foreach ($this->fileList->getFiles() as $scope => $files) {
            foreach ($files as $file) {
                if (\array_key_exists($scope, $scopeData) && !empty($scopeData[$scope])) {
                    $this->scopeConfigGenerator->generate($file, $scopeData[$scope]);
                }
            }
        }
    }
}
