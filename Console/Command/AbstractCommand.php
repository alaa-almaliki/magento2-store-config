<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Console\Command;

use Alaa\StoreConfig\Model\Config;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class AbstractCommand
 *
 * @package Alaa\StoreConfig\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * AbstractCommand constructor.
     *
     * @param Config $config
     * @param string|null $name
     */
    public function __construct(Config $config, string $name = null)
    {
        parent::__construct($name);
        $this->config = $config;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        if ($this->config->isEnabled()) {
            $this->doExecute($input, $output);
            return;
        }

        $output->writeln("<info>Store Config is disabled.</info>");
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    abstract protected function doExecute(InputInterface $input, OutputInterface $output);
}
