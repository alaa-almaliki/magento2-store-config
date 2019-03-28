<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Console\Command;

use Alaa\StoreConfig\Model\Api\ConfigWriterInterface;
use Alaa\StoreConfig\Model\Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class ConfigurationWriterCommand
 *
 * @package Alaa\StoreConfig\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigurationWriterCommand extends AbstractCommand
{
    /**
     * @var ConfigWriterInterface
     */
    protected $configWriter;

    /**
     * ConfigurationWriterCommand constructor.
     *
     * @param ConfigWriterInterface $configWriter
     * @param Config $config
     * @param string|null $name
     */
    public function __construct(Config $config, ConfigWriterInterface $configWriter, string $name = null)
    {
        parent::__construct($config, $name);
        $this->configWriter = $configWriter;
    }

    /**
     * @inheritdoc
     */
    protected function configure()
    {
        parent::configure();
        $this->setName('store-config:configure');
        $this->setDescription('Execute configurations');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function doExecute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln("<info>Starting executing configurations</info>");
        $this->configWriter->configure();
        $output->writeln("<info>Configuration done.</info>");
    }
}
