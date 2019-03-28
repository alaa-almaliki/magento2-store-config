<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Logger;

use Magento\Framework\Logger\Handler\Base;

/**
 * Class Handler
 *
 * @package Alaa\StoreConfig\Logger
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Handler extends Base
{
    /**
     * @var int
     */
    protected $loggerType = \Monolog\Logger::INFO;

    /**
     * @var string
     */
    protected $fileName = 'var/log/store-config.log';
}
