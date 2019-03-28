<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Console\Command;

use Alaa\StoreConfig\Model\Api\ConfigDumperInterface;
use Alaa\StoreConfig\Model\Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConfigDumperCommand
 *
 * @package Alaa\StoreConfig\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigDumperCommand extends AbstractCommand
{
    /**
     * @var ConfigDumperInterface
     */
    protected $configDumper;

    /**
     * ConfigDumperCommand constructor.
     *
     * @param Config $config
     * @param ConfigDumperInterface $configDumper
     * @param string|null $name
     */
    public function __construct(Config $config, ConfigDumperInterface $configDumper, string $name = null)
    {
        parent::__construct($config, $name);
        $this->configDumper = $configDumper;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('store-config:dump');
        $this->setDescription('Import configurations to the config files');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function doExecute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Starting configurations Dump</info>");
        $this->configDumper->dump();
        $output->writeln("<info>Configuration Dump done.</info>");
    }
}
