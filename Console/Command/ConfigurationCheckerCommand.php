<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Console\Command;

use Alaa\StoreConfig\Model\Api\ConfigurationCheckerInterface;
use Alaa\StoreConfig\Model\Api\ValidDeployModeInterface;
use Alaa\StoreConfig\Model\Config;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyleFactory;

/**
 * Class ConfigurationCheckerCommand
 *
 * @package Alaa\StoreConfig\Console\Command
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class ConfigurationCheckerCommand extends AbstractCommand
{
    /**
     * @var ConfigurationCheckerInterface
     */
    protected $configurationChecker;

    /**
     * @var ValidDeployModeInterface
     */
    protected $deployMode;

    /**
     * @var SymfonyStyleFactory
     */
    protected $symfonyStyleFactory;

    /**
     * ConfigurationCheckerCommand constructor.
     *
     * @param Config $config
     * @param ConfigurationCheckerInterface $configurationChecker
     * @param ValidDeployModeInterface $deployMode
     * @param SymfonyStyleFactory $symfonyStyleFactory
     * @param string|null $name
     */
    public function __construct(
        Config $config,
        ConfigurationCheckerInterface $configurationChecker,
        ValidDeployModeInterface $deployMode,
        SymfonyStyleFactory $symfonyStyleFactory,
        string $name = null
    ) {
        parent::__construct($config, $name);
        $this->configurationChecker = $configurationChecker;
        $this->deployMode = $deployMode;
        $this->symfonyStyleFactory = $symfonyStyleFactory;
    }

    /**
     * @inheritdoc
     */
    public function configure()
    {
        parent::configure();
        $this->setName('store-config:check');
        $this->setDescription('Checks configurations');
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|void|null
     */
    protected function doExecute(InputInterface $input, OutputInterface $output)
    {
        $io = $this->symfonyStyleFactory->create(['input' => $input, 'output' => $output]);
        foreach ($this->deployMode->toArray() as $deployMode) {
            $msg = sprintf('Configurations for %s mode passed all checks ok.', $deployMode);
            if (!$this->configurationChecker->checkMode($deployMode)) {
                $msg = ucfirst($deployMode) .
                    ' Configurations did not pass all checks,'.
                    ' please review missing arguments or remove sensitive paths';
                $io->warning($msg);
                continue;
            }
            $io->success($msg);
        }
    }
}
