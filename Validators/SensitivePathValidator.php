<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Validators;

use Magento\Config\Model\Config\TypePool;

/**
 * Class SensitivePathValidator
 *
 * @package Alaa\StoreConfig\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class SensitivePathValidator
{
    /**
     * @var TypePool
     */
    protected $typePool;

    /**
     * SensitivePathValidator constructor.
     *
     * @param TypePool $typePool
     */
    public function __construct(TypePool $typePool)
    {
        $this->typePool = $typePool;
    }

    /**
     * @param array $config
     * @return bool
     */
    public function validate(array $config): bool
    {
        return $this->typePool->isPresent($config['path'], TypePool::TYPE_SENSITIVE) !== true;
    }
}
