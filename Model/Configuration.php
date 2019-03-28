<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Alaa\StoreConfig\Model\Api\ConfigurationInterface;
use Alaa\StoreConfig\Validators\RequiredArgumentsValidator;
use Alaa\StoreConfig\Validators\SensitivePathValidator;

/**
 * Class Configuration
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * @var Scopes
     */
    protected $scopes;

    /**
     * @var RequiredArgumentsValidator
     */
    protected $requiredArgumentsValidator;

    /**
     * @var LoggerPool
     */
    protected $loggerPool;

    /**
     * @var SensitivePathValidator
     */
    protected $sensitivePathValidator;

    /**
     * Configuration constructor.
     *
     * @param Scopes $scopes
     * @param RequiredArgumentsValidator $requiredArgumentsValidator
     * @param SensitivePathValidator $sensitivePathValidator
     * @param LoggerPool $loggerPool
     */
    public function __construct(
        Scopes $scopes,
        RequiredArgumentsValidator $requiredArgumentsValidator,
        SensitivePathValidator $sensitivePathValidator,
        LoggerPool $loggerPool
    ) {
        $this->scopes = $scopes;
        $this->requiredArgumentsValidator = $requiredArgumentsValidator;
        $this->loggerPool = $loggerPool;
        $this->sensitivePathValidator = $sensitivePathValidator;
    }

    /**
     * @param ConfigFileInterface $configFile
     * @return array
     */
    public function getConfigurationsByConfigFile(ConfigFileInterface $configFile): array
    {
        $scopeId = $this->scopes->getScopeId($configFile);
        $configs = [];
        foreach ($configFile->getConfigurations() as $config) {
            if (!$this->requiredArgumentsValidator->validate($config)) {
                $this->loggerPool->warning('Config is missing a path or value argument', $config);
                continue;
            }

            if (!$this->sensitivePathValidator->validate($config)) {
                $this->loggerPool->warning(
                    sprintf('Path %s is set as sensitive data, consider removing it', $config['path'])
                );
            }

            $configuration = [
                'path' => $config['path'],
                'value' => $config['value'],
                'scope' => $configFile->getScope(),
                'scope_id' => $scopeId
            ];

            $configs[] = $configuration;
        }

        return $configs;
    }
}
