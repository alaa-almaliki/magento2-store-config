<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;

/**
 * Class Config
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Config
{
    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * Config constructor.
     *
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(ScopeConfigInterface $scopeConfig)
    {
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * @return bool
     */
    public function isEnabled(): bool
    {
        return $this->getFlag('enabled');
    }

    /**
     * @return bool
     */
    public function isRecurringEnabled(): bool
    {
        return (bool) ($this->getFlag('recurring_enabled') && $this->isEnabled());
    }

    /**
     * @param string $loggerName
     * @return bool
     */
    public function isLoggerEnabled(string $loggerName): bool
    {
        $method = $this->getMethodName($loggerName);
        return $this->$method();
    }

    /**
     * @return bool
     */
    public function isFileLoggerEnabled(): bool
    {
        return $this->getFlag('file_logger_enabled');
    }

    /**
     * @return bool
     */
    public function isConsoleLoggerEnabled(): bool
    {
        return $this->getFlag('console_logger_enabled');
    }

    /**
     * @param string $section
     * @return mixed
     */
    protected function getFlag(string $section): bool
    {
        return (bool) $this->scopeConfig->isSetFlag('store_config/general/' . $section);
    }

    /**
     * @param string $loggerName
     * @return string
     */
    protected function getMethodName(string $loggerName): string
    {
        $parts = [
            'is',
            ucfirst($loggerName),
            'Enabled'
        ];

        return implode('', $parts);
    }
}
