<?php
/**
 * @copyright 2019 Alaa Al-Maliki <alaa.almaliki@gmail.com>
 * @license   MIT
 */

declare(strict_types=1);

namespace Alaa\StoreConfig\Validators;

/**
 * Class RequiredArgumentsValidator
 *
 * @package Alaa\StoreConfig\Validators
 * @author  Alaa Al-Maliki <alaa.almaliki@gmail.com>
 */
class RequiredArgumentsValidator
{
    /**
     * @var array
     */
    protected $requiredArguments;

    /**
     * @var int
     */
    protected $count = -1;

    /**
     * RequiredArgumentsValidator constructor.
     *
     * @param array $requiredArguments
     */
    public function __construct(array $requiredArguments)
    {
        $this->requiredArguments = $requiredArguments;
    }

    /**
     * @param array $arguments
     * @return bool
     */
    public function validate(array $arguments): bool
    {
        return $this->getExistingArgumentsCount($arguments) === $this->getRequiredArgumentsCount();
    }

    /**
     * @param array $arguments
     * @return int
     */
    protected function getExistingArgumentsCount(array $arguments): int
    {
        return \count(array_intersect($this->requiredArguments, \array_keys($arguments)));
    }

    /**
     * @return int
     */
    protected function getRequiredArgumentsCount(): int
    {
        if (-1 === $this->count) {
            $this->count = \count($this->requiredArguments);
        }

        return $this->count;
    }
}
