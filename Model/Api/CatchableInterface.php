<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

/**
 * Interface CatchableInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface CatchableInterface
{
    /**
     * @param callable $callback
     * @param null $defaultValue
     * @return mixed
     */
    public function catch(callable $callback, $defaultValue = null);
}
