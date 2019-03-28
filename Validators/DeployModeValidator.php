<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Validators;

use Magento\Framework\App\State;

/**
 * Class DeployModeValidator
 *
 * @package Alaa\StoreConfig\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class DeployModeValidator
{
    protected $validDeployModes = [
      State::MODE_DEVELOPER,
      State::MODE_PRODUCTION,
    ];

    /**
     * @param string $deployMode
     * @return bool
     */
    public function validate(string $deployMode): bool
    {
        return in_array($deployMode, $this->validDeployModes);
    }
}
