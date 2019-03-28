<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

/**
 * Class LoggerPool
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class LoggerPool
{
    /**
     * @var array
     */
    protected $loggers;

    /**
     * @var Config
     */
    protected $config;

    /**
     * LoggerPool constructor.
     *
     * @param array $loggers
     * @param Config $config
     */
    public function __construct(array $loggers, Config $config)
    {
        $this->loggers = $loggers;
        $this->config = $config;
    }

    /**
     * @param string $name
     * @param array $arguments
     */
    public function __call($name, $arguments)
    {
        foreach ($this->loggers as $loggerName => $logger) {
            if ($this->config->isLoggerEnabled($loggerName)) {
                if (method_exists($logger, $name)) {
                    call_user_func_array([$logger, $name], $arguments);
                }
            }
        }
    }
}
