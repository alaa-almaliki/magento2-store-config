<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Setup;

use Alaa\StoreConfig\Model\Api\ConfigWriterInterface;
use Alaa\StoreConfig\Model\Config;
use Magento\Framework\Setup\InstallSchemaInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\SchemaSetupInterface;

/**
 * Class Recurring
 *
 * @package Alaa\StoreConfig\Setup
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Recurring implements InstallSchemaInterface
{
    /**
     * @var ConfigWriterInterface
     */
    protected $configWriter;

    /**
     * @var Config
     */
    protected $config;

    /**
     * Recurring constructor.
     *
     * @param ConfigWriterInterface $configWriter
     * @param Config $config
     */
    public function __construct(ConfigWriterInterface $configWriter, Config $config)
    {
        $this->configWriter = $configWriter;
        $this->config = $config;
    }

    /**
     * Installs DB schema for a module
     *
     * @param SchemaSetupInterface $setup
     * @param ModuleContextInterface $context
     * @return void
     */
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        if ($this->config->isRecurringEnabled()) {
            $this->configWriter->configure();
        }
    }
}
