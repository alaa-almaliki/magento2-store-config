<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

use Magento\Framework\App\State;

/**
 * Interface ValidDeployModeInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ValidDeployModeInterface
{
    public const DEPLOY_MODE_DEVELOPER  = State::MODE_DEVELOPER;
    public const DEPLOY_MODE_PRODUCTION = State::MODE_PRODUCTION;

    /**
     * @return array
     */
    public function toArray(): array;
}
