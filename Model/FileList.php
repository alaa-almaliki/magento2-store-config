<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Model;

use Alaa\StoreConfig\Api\Data\ConfigFileInterface;
use Alaa\StoreConfig\Model\Api\FileListInterface;
use Alaa\StoreConfig\Model\Api\FileLocatorInterface;
use Alaa\StoreConfig\Validators\DeployModeValidator;
use Magento\Framework\App\State;

/**
 * Class FileList
 *
 * @package Alaa\StoreConfig\Model
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class FileList implements FileListInterface
{
    /**
     * @var State
     */
    protected $appState;

    /**
     * @var FileLocatorInterface
     */
    protected $fileLocator;

    /**
     * @var DeployModeValidator
     */
    protected $deployModeValidator;

    /**
     * FileList constructor.
     *
     * @param State $appState
     * @param FileLocatorInterface $fileLocator
     * @param DeployModeValidator $deployModeValidator
     */
    public function __construct(
        State $appState,
        FileLocatorInterface $fileLocator,
        DeployModeValidator $deployModeValidator
    ) {
        $this->appState = $appState;
        $this->fileLocator = $fileLocator;
        $this->deployModeValidator = $deployModeValidator;
    }

    /**
     * @return ConfigFileInterface[]|array
     */
    public function getFiles(): array
    {
        $deployMode = $this->appState->getMode();
        if ($this->deployModeValidator->validate($deployMode)) {
            return $this->fileLocator->locate($deployMode);
        }

        return [];
    }
}
