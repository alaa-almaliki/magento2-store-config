<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model\Api;

/**
 * Interface ConfigWriterInterface
 *
 * @package Alaa\StoreConfig\Model\Api
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
interface ConfigWriterInterface
{
    /**
     * @return void
     */
    public function configure();

    /**
     * @param array $configurations
     * @return void
     */
    public function doConfigure(array $configurations);
}
