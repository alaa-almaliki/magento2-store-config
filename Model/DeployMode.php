<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Model\Api\CatchableInterface;
use Alaa\StoreConfig\Model\Api\ValidDeployModeInterface;
use ReflectionClass;

/**
 * Class DeployMode
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class DeployMode implements ValidDeployModeInterface
{
    /**
     * @var CatchableInterface
     */
    protected $catchable;

    /**
     * DeployMode constructor.
     *
     * @param CatchableInterface $catchable
     */
    public function __construct(CatchableInterface $catchable)
    {
        $this->catchable = $catchable;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->catchable->catch(function () {
            $ref = new ReflectionClass(self::class);
            return $ref->getConstants();
        }, []);
    }
}
