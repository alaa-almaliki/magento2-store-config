<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Model\Api\ConfigReaderInterface;
use Alaa\StoreConfig\Model\Api\ConfigWriterInterface;
use Magento\Framework\App\Config\Storage\WriterInterface;

/**
 * Class ConfigWriter
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigWriter implements ConfigWriterInterface
{
    /**
     * @var ConfigReaderInterface
     */
    protected $configReader;

    /**
     * @var WriterInterface
     */
    protected $dbConfigWriter;

    /**
     * ConfigWriter constructor.
     *
     * @param ConfigReaderInterface $configReader
     * @param WriterInterface $dbConfigWriter
     */
    public function __construct(ConfigReaderInterface $configReader, WriterInterface $dbConfigWriter)
    {
        $this->configReader = $configReader;
        $this->dbConfigWriter = $dbConfigWriter;
    }

    /**
     * @inheritdoc
     */
    public function configure()
    {
        foreach ($this->configReader->getConfigurations() as $configurations) {
            $this->doConfigure($configurations);
        }
    }

    /**
     * @inheritdoc
     */
    public function doConfigure(array $configurations)
    {
        foreach ($configurations as $configuration) {
            $this->dbConfigWriter->save(...array_values($configuration));
        }
    }
}
