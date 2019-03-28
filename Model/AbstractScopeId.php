<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Alaa\StoreConfig\Model\Api\CatchableInterface;
use Magento\Store\Model\StoreManagerInterface;

/**
 * Class AbstractScopeId
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
abstract class AbstractScopeId
{
    /**
     * @var StoreManagerInterface
     */
    protected $storeManager;

    /**
     * @var CatchableInterface
     */
    protected $catchable;

    /**
     * AbstractScopeId constructor.
     *
     * @param StoreManagerInterface $storeManager
     * @param CatchableInterface $catchable
     */
    public function __construct(StoreManagerInterface $storeManager, CatchableInterface $catchable)
    {
        $this->storeManager = $storeManager;
        $this->catchable = $catchable;
    }

    /**
     * @param ConfigFileInterface $configFile
     * @return string|int|null
     */
    abstract public function getScopeId(ConfigFileInterface $configFile);
}
