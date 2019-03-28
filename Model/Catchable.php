<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Model\Api\CatchableInterface;
use Exception;

/**
 * Class Catchable
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class Catchable implements CatchableInterface
{
    /**
     * @param callable $callback
     * @param null $defaultValue
     * @return mixed|null
     */
    public function catch(callable $callback, $defaultValue = null)
    {
        try {
            return $callback();
        } catch (Exception $e) {
            return $defaultValue;
        }
    }
}
